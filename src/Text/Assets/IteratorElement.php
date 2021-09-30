<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Text;

class IteratorElement
{
	public function __construct(
		public int $i,
		public int $cursor,
		public Text $text
	)
	{

	}

	public function index(): int
	{
		return $this->i;
	}

	public function cursor(): int
	{
		return $this->cursor;
	}

	public function text(): Text
	{
		return $this->text;
	}
}
