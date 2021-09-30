<?php

namespace Markhj\Text\DataMap;

use Markhj\Text\Assets\DataCollection;

abstract class DataMap
{
	protected DataCollection $collection;

	final public function __construct()
	{
		$this->collection = new DataCollection;
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
