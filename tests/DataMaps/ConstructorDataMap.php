<?php

namespace Markhj\Text\Tests\DataMaps;

use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;

class ConstructorDataMap extends DataMap
{
	public function __construct(
		protected string $custom
	) {
		parent::__construct();
	}

	#[DataMapKey]
	public function value()
	{
		return $this->custom;
	}
}
