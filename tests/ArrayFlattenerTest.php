<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Assets\ArrayFlattener;

class ArrayFlattenerTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$array = [
			'name' => 'John Doe',
			'location' => [
				'city' => 'Bern',
				'country' => [
					'code' => 'CH',
					'currency' => [
						'code' => 'CHF',
					],
				],
			],
		];

		$this->assertEquals(
			[
				'name' => 'John Doe',
				'location.city' => 'Bern',
				'location.country.code' => 'CH',
				'location.country.currency.code' => 'CHF',
			],
			(new ArrayFlattener)->flatten($array)
		);
	}
}