<?php

namespace Markhj\Text;

class TextFromFile extends Text
{
	public function __construct(
		protected string $filename
	) {
		parent::__construct(file_get_contents($filename));
	}

	public function save(?string $to = null): TextFromFile
	{
		file_put_contents($to ?? $this->filename, $this->parse());

		return $this;
	}
}
