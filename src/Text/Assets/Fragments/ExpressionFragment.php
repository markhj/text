<?php

namespace Markhj\Text\Assets\Fragments;

use Markhj\Collection\AssociativeCollection;
use Markhj\Text\Expression;

class ExpressionFragment extends Fragment
{
	protected string $output = '';

	public function __construct(
		Expression $expression
	) {
		$this->expression = $expression;
	}

	public function foundation(): string
	{
		return $this->expression->signature();
	}

	public function get()
	{
		return $this->output;
	}

	public function set($value): Fragment
	{
		$this->output = $value;

		return $this;
	}

	public function arguments(): AssociativeCollection
	{
		return $this->expression->arguments();
	}

	public function argument(string|int $key): mixed
	{
		return $this->expression->arguments()->get($key);
	}
}
