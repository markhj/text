<?php

namespace Markhj\Text\Attributes\DataMap;

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
