<?php

namespace Markhj\Text\Assets;

use Markhj\Collection\AssociativeCollection;
use Markhj\Text\Exceptions\InvalidNamespaceException;
use Markhj\Text\Exceptions\InvalidDataMapKeyException;
use Markhj\Text\Assets\Validators\NamespaceValidator;
use Markhj\Text\Assets\Validators\DataMapKeyValidator;
use Markhj\Text\DataMap\DataMap;

class Repository
{
	protected AssociativeCollection $data;
	protected ?string $workingInNamespace = null;

	public function __construct()
	{
		$this->data = (new AssociativeCollection)->graceful();
	}

	public function provide(string|DataMap $dataMap): Repository
	{
		if (is_string($dataMap)) {
			$dataMap = new $dataMap;
		}

		foreach ($dataMap->flatten() as $key => $value) {
			$this->set($key, $value);
		}

		return $this;
	}

	protected function validateNamespace(string $namespace): void
	{
		if (!(new NamespaceValidator)->validate($namespace)) {
			throw new InvalidNamespaceException;
		}
	}

	protected function validateKey(string $key): void
	{
		if (!(new DataMapKeyValidator)->validate($key)) {
			throw new InvalidDataMapKeyException;
		}
	}

	public function in(string $namespace): Repository
	{
		$this->validateNamespace($namespace);

		$this->workingInNamespace = $namespace;

		return $this;
	}

	public function root(): Repository
	{
		$this->workingInNamespace = null;

		return $this;
	}

	public function merge(Repository $repository): Repository
	{
		foreach ($repository->collection() as $key => $value) {
			$this->set($key, $value);
		}

		return $this;
	}

	public function set(string $key, string|array $value): Repository
	{
		$this->validateKey($key);

		if ($this->workingInNamespace) {
			$key = rtrim($this->workingInNamespace, '.') . '.' . $key;
		}

		if (is_string($value)) {
			$this->data->set($key, $value);
		} else if (is_array($value)) {
			foreach ((new ArrayFlattener)->flatten($value) as $a => $value) {
				$this->data->set(rtrim($key, '.') . '.' . ltrim($a, '.'), $value);
			}
		}

		return $this;
	}

	public function collection(): AssociativeCollection
	{
		return $this->data;
	}

	public function get(string $key): string
	{
		return $this->data->get($key) ?? '';
	}
}
