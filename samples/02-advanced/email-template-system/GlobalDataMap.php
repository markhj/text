<?php

use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;

class GlobalDataMap extends DataMap
{
	#[DataMapKey]
	public function currency(): string
	{
		return 'DKK';
	}
}
