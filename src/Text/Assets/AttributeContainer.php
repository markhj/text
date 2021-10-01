<?php

namespace Markhj\Text\Assets;

use ReflectionAttribute;

class AttributeContainer
{
	public function __construct(
		protected ReflectionAttribute $attribute,
		protected mixed $object
	) {}

	public function attribute(): ReflectionAttribute
	{
		return $this->attribute;
	}

	public function get(): mixed
	{
		return $this->object;
	}
}
