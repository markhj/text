<?php

namespace Markhj\Text\Attributes\Parser;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class DefaultParserName
{
	public function __construct(
		protected string $name
	) { }

	public function getName(): string
	{
		return $this->name;
	}
}
