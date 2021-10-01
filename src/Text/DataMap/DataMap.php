<?php

namespace Markhj\Text\DataMap;

use Markhj\Text\Assets\DataCollection;
use Markhj\Text\Assets\AttributeReader;
use Markhj\Text\Assets\AttributeContainer;
use Markhj\Text\Attributes\DataMap\DataMapKey;

abstract class DataMap
{
	protected DataCollection $collection;

	public function __construct()
	{
		$this->collection = new DataCollection;

		$this->mapProperties();
		$this->mapMethods();
	}

	final protected function mapMethods(): void
	{
		(new AttributeReader)
			->methodsWith($this, DataMapKey::class)
			->forEach(function(AttributeContainer $container) {
				$method = $container->get();

				$this->collection->set($method->getName(), $this->{$method->getName()}());
			});
	}

	final protected function mapProperties(): void
	{
		(new AttributeReader)
			->propertiesWith($this, DataMapKey::class)
			->forEach(function(AttributeContainer $container) {
				$property = $container->get();

				$this->collection->set($property->getName(), $property->getValue($this));
			});
	}

	final public function flatten(): array
	{
		return $this->collection->all();
	}

	final public function set(
		string $key,
		mixed $value
	): DataMap
	{
		$this->collection->set($key, $this->primitive($value));

		return $this;
	}

	final protected function primitive(mixed $value): mixed
	{
		if (
			is_int($value)
			|| is_float($value)
			|| is_string($value)
			|| is_array($value)
			|| is_null($value)
		) {
			return $value;
		}

		return [

		];
	}

	final public function delete(string ...$keys): DataMap
	{
		$this->collection->remove(...$keys);

		foreach ($keys as $key) {

		}

		return $this;
	}
}
