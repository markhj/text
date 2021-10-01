<?php

namespace Markhj\Text\Tests\DataMaps;

use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;

class StaticDataMap extends DataMap
{
	#[DataMapKey]
	public string $property = 'static value';

	#[DataMapKey]
	public function currency(): string
	{
		if (true) {
			return 'DKK';
		} else {
			return 'SEK';
		}
	}
}
