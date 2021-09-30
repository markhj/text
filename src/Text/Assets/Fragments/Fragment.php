<?php

namespace Markhj\Text\Assets\Fragments;

use Markhj\Text\Expression;

abstract class Fragment
{
	protected ?Expression $expression = null;

	abstract public function foundation(): string;
	abstract public function get();
	abstract public function set($value): Fragment;

	final public function isExpression(): bool
	{
		return !! $this->expression;
	}

	final public function expression(): ?Expression
	{
		return $this->expression;
	}
}
