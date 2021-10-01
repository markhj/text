<?php

namespace Markhj\Text\Attributes\DataMap;

use Attribute;

#[Attribute]
class DataMapGroup
{
	public function __construct(
		protected string $name
	) { }
}
