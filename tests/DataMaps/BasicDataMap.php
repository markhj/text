<?php

namespace Markhj\Text\Tests\DataMaps;

use Markhj\Text\DataMap\DataMap;

#[DataMapGroup(name: 'basics')]
class BasicDataMap extends DataMap
{
	public string $a = 'world';
}
