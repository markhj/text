<?php

namespace Markhj\Text\Assets;

use Markhj\Collection\Collection;
use Markhj\Text\Assets\AttributeContainer;
use ReflectionClass;

class AttributeReader
{
	protected function getAttributesFrom(
		$source,
		string $method,
		string ...$attributeClassNames
	): Collection
	{
		$collection = new Collection;
		$reflection = new ReflectionClass($source);
		$classNames = (new Collection)->push(...$attributeClassNames);

		foreach ($reflection->{$method}() as $object) {
			foreach ($object->getAttributes() as $attribute) {
				if ($classNames->has($attribute->getName())) {
					$collection->push(
						new AttributeContainer(
							$attribute,
							$object
						)
					);
				}
			}
		}

		return $collection;
	}

	public function propertiesWith(
		$source,
		string ...$attributeClassNames
	): Collection
	{
		return $this->getAttributesFrom(
			$source,
			'getProperties',
			...$attributeClassNames
		);
	}

	public function methodsWith(
		$source,
		string ...$attributeClassNames
	): Collection
	{
		return $this->getAttributesFrom(
			$source,
			'getMethods',
			...$attributeClassNames
		);
	}
}
