<?php

namespace Markhj\Text;

use Markhj\Text\Exceptions\LoopProtectionException;
use Markhj\Collection\Collection;

/**
 * @todo toNext (string and regexp)
 * @todo toPrevious (string and regexp)
 */
class Cursor
{
	protected string $text;
	protected int $position = 0;
	protected ?string $selection = null;

	protected Collection $collection;
	protected Collection $slices;

	public function __construct(
		string $text
	) {
		$this->collection = new Collection;
		$this->slices = new Collection;
		$this->text = $text;
	}

	public function slice(): Cursor
	{
		$this->slices->push($this->position());

		return $this;
	}

	public function get(): string
	{
		return $this->text;
	}

	public function char(): ?string
	{
		return $this->text[$this->position()] ?? null;
	}

	public function delete(int $chars = 1): Cursor
	{
		$position = $this->position();

		$this->text =  mb_substr($this->text, 0, $position)
			. mb_substr($this->text, $position + $chars);

		return $this;
	}

	public function backspace(int $chars = 1): Cursor
	{
		$position = $this->position();
		$keep = mb_substr($this->text, $position);

		$this->text = mb_substr($this->text, 0, $position - $chars) . $keep;

		return $this->move(-$chars);
	}

	public function insert(string|Text $text): Cursor
	{
		$position = $this->position();

		$this->text = mb_substr($this->text, 0, $position)
			. $text
			. mb_substr($this->text, $position);

		return $this->move($text);
	}

	public function slices(): Collection
	{
		$collection = new Collection;
		$previous = 0;
		$slices = $this->slices;
		$max = mb_strlen($this->text);

		if ($slices->last() != $max) {
			$slices->push($max);
		}

		foreach ($slices as $i => $split) {
			$collection->push(mb_substr($this->text, $previous, $split - $previous));

			$previous = $split;
		}

		return $collection;
	}

	public function toNext(string $char): Cursor
	{
		$substr = mb_substr($this->text, $this->position() + 1);
		$pos = strpos($substr, $char) + 1;

		if (is_int($pos)) {
			$this->move($pos);
		}

		return $this;
	}

	public function position(): int
	{
		return $this->position;
	}

	public function selection(): ?string
	{
		return $this->selection;
	}

	public function toEnd(): Cursor
	{
		return $this->set(mb_strlen($this->text));
	}

	public function set(int $position): Cursor
	{
		$current = $this->position();
		$length = mb_strlen($this->text);

		if ($position > $length) {
			$position = $length;
		} else if ($position < 0) {
			$position = 0;
		}

		$this->position = $position;

		$from = $current > $position ? $position : $current;
		$length = abs($current - $position);

		$this->selection = mb_substr($this->text, $from, $length);

		return $this;
	}

	public function rewind(): Cursor
	{
		return $this->set(0);
	}

	public function ended(): bool
	{
		return $this->position() >= mb_strlen($this->text);
	}

	public function move(int|string|Text $size = 1): Cursor
	{
		$move = match (true) {
			is_int($size) => $size,
			is_string($size) => mb_strlen($size),
			$size::class == Text::class => $size->length()
		};

		$this->set($this->position() + $move);

		return $this;
	}

	public function prev(): Cursor
	{
		return $this->move(-1);
	}

	public function next(): Cursor
	{
		return $this->move();
	}

	public function while(callable $action): Cursor
	{
		$counter = 0;

		while (!$this->ended()) {
			$action($this);

			$counter++;
			if ($counter > 100000) {
				throw new LoopProtectionException;
			}
		}

		return $this;
	}
}
