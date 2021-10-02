<?php

namespace Markhj\Text\Assets\Fragments;

class TextFragment extends Fragment
{
	public function __construct(
		protected string $text
	) { }

	public function rebase($foundation): Fragment
	{
		$this->text = $foundation;

		return $this;
	}

	public function foundation(): string
	{
		return $this->text;
	}

	public function get()
	{
		return $this->text;
	}

	public function set($value): Fragment
	{
		$this->text = $value;

		return $this;
	}
}
