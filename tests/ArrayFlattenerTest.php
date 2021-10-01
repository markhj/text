<?php

namespace Markhj\Text\Test;

use Markhj\Text\Assets\ArrayFlattener;
use PHPUnit\Framework\TestCase;

class ArrayFlattenerTest extends TestCase
{
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