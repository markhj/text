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
		protected string $end = ''
	) {
		if (strlen($arguments) != 2) {
			throw new InvalidExpressionPatternException;
		}
	}

	public function __toString()
	{
		return $this->toRegExp();
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
