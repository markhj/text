<?php

namespace Markhj\Text;

use Markhj\Text\Text;
use Markhj\Text\Exceptions\StringNotValidForOperationException;

class Decoration
{
	protected string $string;

	public function __construct(
		protected Text|string $source
	) {
		$this->string = (string) $source;
	}

	public function __toString(): string
	{
		return $this->string;
	}

	protected function set(string $string): Decoration
	{
		$this->string = $string;

		if (get_class($this->source) == Text::class) {
			$this->source->set($this->string);
		}

		return $this;
	}

	protected function get(): string
	{
		return $this->string;
	}

	public function crop(int $from, int $length): Decoration
	{
		return $this->set(mb_substr($this->get(), $from, $length));
	}

	public function trim(string $char = ' '): Decoration
	{
		return $this->trimLeft($char)->trimRight($char);
	}

	public function trimLeft(string $char = ' '): Decoration
	{
		return $this->set(ltrim($this->get(), $char));
	}

	public function trimRight(string $char = ' '): Decoration
	{
		return $this->set(rtrim($this->get(), $char));
	}

	public function substr(int $offset, ?int $length = null): Decoration
	{
		return $this->set(mb_substr($this->get(), $offset, $length));
	}

	public function studly(): Decoration
	{
		if (!preg_match('/^[a-zA-Z]+(_[a-zA-Z]+){0,}$/', $this->get())) {
			throw new StringNotValidForOperationException(
				'String is not in a suitable format to be parsed as studly'
			);
		}

		return $this->set(ucfirst(
			preg_replace_callback('/_[a-z]/', function($match) {
				return substr(strtoupper($match[0]), 1);
			}, $this->get())
		));
	}

	public function snakecase(): Decoration
	{
		if (!preg_match('/^[a-zA-Z]+$/', $this->get())) {
			throw new StringNotValidForOperationException(
				'String is not in a suitable format to be parsed as studly'
			);
		}

		return $this->set(preg_replace('/^_/', '', strtolower(
			preg_replace_callback('/[A-Z]/', function($match) {
				return '_' . strtoupper($match[0]);
			}, $this->get())
		)));
	}

	public function camelcase(): Decoration
	{
		if (!preg_match('/^[a-zA-Z]+(_[a-zA-Z]+){0,}$/', $this->get())) {
			throw new StringNotValidForOperationException(
				'String is not in a suitable format to be parsed as studly'
			);
		}

		return $this->set(lcfirst(
			preg_replace_callback('/_[a-z]/', function($match) {
				return strtoupper($match[0])[1];
			}, $this->get())
		));
	}
}
