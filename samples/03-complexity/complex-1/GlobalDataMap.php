<?php

use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;
use Markhj\Text\Attributes\DataMap\DefaultParserName;

#[DefaultParserName('intl')]
class GlobalDataMap extends DataMap
{
	#[DataMapKey('currency')]
	public function currency(): string
	{
		return 'DKK';
	}
}
