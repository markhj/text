<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Exceptions\InvalidExpressionPatternException;

class ExpressionPattern
{
	public function __construct(
		protected string $prefix = '#',
		protected string $suffix = '',
		protected string $arguments = '[]',
		protected string $argumentSeparator = '|',
		protected array $argumentQuotes = ['\'', '"'],
		protected string $end = '',
	) {
		if (strlen($arguments) != 2) {
			throw new InvalidExpressionPatternException(
				'Arguments character must be exactly two characters long'
			);
		}

		if (empty($argumentQuotes)) {
			throw new InvalidExpressionPatternException(
				'You must have at least one argument quote'
			);
		}

		if (strlen($argumentSeparator) !== 1) {
			throw new InvalidExpressionPatternException(
				'Argument separator must be exactly one character'
			);
		}

		if (in_array($argumentSeparator, $argumentQuotes)) {
			throw new InvalidExpressionPatternException(
				'Argument separator must be different from all argument quote characters'
			);
		}

		if (
			in_array($arguments[0], $argumentQuotes)
			|| in_array($arguments[1], $argumentQuotes)
		) {
			throw new InvalidExpressionPatternException(
				'Argument parentheses must be different from all argument quote characters'
			);
		}

		if (
			$arguments[0] == $argumentSeparator
			|| $arguments[1] == $argumentSeparator
		) {
			throw new InvalidExpressionPatternException(
				'Argument parentheses must be different from argument separator'
			);
		}
	}

	public function __toString()
	{
		return $this->toRegExp();
	}

	public function prefix(): string
	{
		return $this->prefix;
	}

	public function suffix(): string
	{
		return $this->suffix;
	}

	public function arguments(): string
	{
		return $this->arguments;
	}

	public function end(): string
	{
		return $this->end;
	}

	public function argumentQuotes(): array
	{
		return $this->argumentQuotes;
	}

	public function argumentSeparator(): string
	{
		return $this->argumentSeparator;
	}

	public function toRegExp(): string
	{
		return str_replace(
			[
				':prefix',
				':suffix',
				':argl',
				':argr',
				':end',
			],
			[
				$this->escape($this->prefix),
				$this->escape($this->suffix),
				$this->escape($this->arguments[0]),
				$this->escape($this->arguments[1]),
				$this->escape($this->end),
			],
			'/:prefix([a-z]*):suffix(:argl([^:argr]*):argr:end)/im'
		);
	}

	protected function escape(string $in): string
	{
		return preg_quote($in);
	}
}
