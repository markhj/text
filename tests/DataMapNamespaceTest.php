<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\DataContainer;
use Markhj\Text\Tests\DataMaps\BasicDataMap;
use Markhj\Text\Tests\DataMaps\StaticDataMap;
use Markhj\Text\Tests\DataMaps\ConstructorDataMap;
use Markhj\Text\DataMap\EmptyDataMap;
use Markhj\Text\Exceptions\InvalidNamespaceException;

class DataMapNamespaceTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 */
	public function invalidNamespace1(): void
	{
		$this->expectException(InvalidNamespaceException::class);

		(new Text(''))->repository()->in('.namespace');
	}

	/**
	 * @test
	 */
	public function invalidNamespace2(): void
	{
		$this->expectException(InvalidNamespaceException::class);

		(new Text(''))->repository()->in('name123.space');
	}

	/**
	 * @test
	 */
	public function invalidNamespace3(): void
	{
		$this->expectException(InvalidNamespaceException::class);

		(new Text(''))->repository()->in('namespace.');
	}

	/**
	 * @test
	 */
	public function validNamespace(): void
	{
		$this->expectNotToPerformAssertions();

		(new Text(''))->repository()->in('name.space');
		(new Text(''))->repository()->in('name.space.sub');
	}

	/**
	 * @test
	 * @return void
	 */
	public function namespaceSimple(): void
	{
		$text = new Text('Hello #p[child.node.my]!');

		$text->repository()->in('child.node')->set('my', 'world');

		$this->assertEquals(
			'Hello world!',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function namespaceMap(): void
	{
		$text = new Text('Hello #p[child.node.property] #p[child.node.currency]');

		$text->repository()->in('child.node')->provide(StaticDataMap::class);

		$this->assertEquals(
			'Hello static value DKK',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function namespaceNested(): void
	{
		$text = new Text(
			'Hello #p[child.node.my.name]. You were born in #p[child.node.my.location.country.name]!'
		);

		$array = [
			'name' => 'John Doe',
			'location' => [
				'city' => 'Bern',
				'country' => [
					'name' => 'Switzerland',
					'currency' => [
						'code' => 'CHF',
					],
				],
			],
		];

		$text->repository()->in('child.node')->set('my', $array);

		$this->assertEquals(
			'Hello John Doe. You were born in Switzerland!',
			$text->parse()
		);
	}
}