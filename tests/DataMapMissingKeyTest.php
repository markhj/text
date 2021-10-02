<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\DataContainer;
use Markhj\Text\Tests\DataMaps\BasicDataMap;
use Markhj\Text\Tests\DataMaps\StaticDataMap;
use Markhj\Text\Tests\DataMaps\ConstructorDataMap;
use Markhj\Text\DataMap\EmptyDataMap;

class DataMapMissingKeyTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function default(): void
	{
		$text = new Text('Hello #p[doesntexist]!');

		$this->assertEquals(
			'Hello !',
			$text->parse()
		);
	}
}