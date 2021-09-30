<?php

namespace Markhj\Text;

use Markhj\Collection\Collection;
use Markhj\Text\Exceptions\IndexNotSelectedException;
use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Assets\IteratorElement;
use Markhj\Text\Assets\Instruction;
use Markhj\Text\Assets\ExpressionPattern;

/**
 * @todo trim, ltirm and rtrim
 * @todo crop
 * @todo Laravel-helpers: camel, studly, etc.
 */
class Text
{
	protected string $template;
	protected int|string|null $index = null;
	protected Collection $instructions;
	protected ?ExpressionPattern $expressionPattern = null;

	public function __construct(
		string $template
	)
	{
		$this->template = $this->encode($template);
		$this->instructions = new Collection;
	}

	public function __toString(): string
	{
		return $this->parse();
	}

	public function setExpressionPattern(ExpressionPattern $pattern): Text
	{
		$this->expressionPattern = $pattern;

		return $this;
	}

	public function crop(int $from, int $length): Text
	{
		$this->template = mb_substr($this->template, $from, $length);

		return $this;
	}

	public function trim(string $char = ' '): Text
	{
		return $this->leftTrim($char)->rightTrim($char);
	}

	public function leftTrim(string $char = ' '): Text
	{
		$this->template = ltrim($this->template, $char);

		return $this;
	}

	public function rightTrim(string $char = ' '): Text
	{
		$this->template = rtrim($this->template, $char);

		return $this;		
	}

	public function parse(): string
	{
		$tokenizer = new Tokenizer;
		$tokens = $tokenizer->tokenize($this->template, $this->expressionPattern);

		foreach ($this->instructions as $instruction) {
			$tokens->map(function(Fragment $fragment) use($instruction) {
				return $this->handleFragment($fragment, $instruction);
			});
		}

		return $tokenizer->glue($tokens);
	}

	public function handleFragment(
		Fragment $fragment,
		Instruction $instruction
	): Fragment
	{
		if ($fragment && $fragment->isExpression()) {
			$expression = $fragment->expression();

			if ($expression->key() === $instruction->index()) {
				$value = $instruction->execute($fragment);

				$fragment->set($value);
			}
		}

		return $fragment;
	}

	public function substr(int $offset, ?int $length = null): Text
	{
		return new Text(mb_substr((string) $this, $offset, $length));
	}

	public function length(): int
	{
		return mb_strlen($this->parse());
	}

	public function byteSize(): int
	{
		return strlen($this->parse());
	}

	public function encode(string $text): string
	{
		return match (strtolower(mb_detect_encoding($text))) {
			'utf-8' => $text,
			default => utf8_encode($text)
		};
	}

	public function on(int|string $index): Text
	{
		$this->index = $index;

		return $this;
	}

	public function do(callable $action): Text
	{
		if (is_null($this->index)) {
			throw new IndexNotSelectedException;
		}

		$instruction = (new Instruction($this->index))->setAction($action);

		$this->instructions->push($instruction);

		return $this;
	}
}
