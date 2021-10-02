<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\DataContainer;
use Markhj\Text\Tests\DataMaps\BasicDataMap;

class DataTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$map = new BasicDataMap;

		$map->set('hello.world', 8);

		$this->assertEquals(
			[
				'hello.world' => 8,
			],
			$map->flatten()
		);

		$map->set('hello.world', 10);

		$this->assertEquals(
			[
				'hello.world' => 10,
			],
			$map->flatten()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function deleteKey(): void
	{
		$map = new BasicDataMap;

		$map->set('hello.world', 8)->set('hello.other', 10);
		
		$this->assertEquals(
			[
				'hello.world' => 8,
				'hello.other' => 10,
			],
			$map->flatten()
		);

		$map->delete('hello.world');

		$this->assertEquals(
			[
				'hello.other' => 10,
			],
			$map->flatten()
		);
	}
}