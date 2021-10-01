<?php

namespace Markhj\Text;

use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Text\Assets\ArgumentReader;
use Markhj\Collection\AssociativeCollection;

class Expression
{
	public function __construct(
		protected string $text,
		?ExpressionPattern $pattern = null
	) {
		$this->signature = $text;
		$this->pattern = $pattern ?? new ExpressionPattern;
		$this->key = preg_replace($this->pattern, '$1', $text);

		$this->arguments = new ArgumentReader(
			preg_replace($this->pattern, '$3', $text),
			$this->pattern
		);
	}

	public function pattern(): ExpressionPattern
	{
		return $this->pattern;
	}

	public function signature(): string
	{
		return $this->signature;
	}

	public function key(): string
	{
		return $this->key;
	}

	public function arguments(): AssociativeCollection
	{
		return $this->arguments;
	}
}
