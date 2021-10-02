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
use Markhj\Text\Exceptions\InvalidDataMapKeyException;

class DataApplicationTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$text = new Text('Hello #p[group.name]');

		$map = new EmptyDataMap;
		$map->set('group.name', 'Group Name');

		$text->repository()->provide($map);
		
		$text->on('p')->do(function($fragment, $repository) {
			return $repository->get($fragment->arguments()->get(0));
		});

		$this->assertEquals(
			'Hello Group Name',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function invalidDataMapKey(): void
	{
		$this->expectException(InvalidDataMapKeyException::class);

		(new Text(''))->repository()->set('.invalid', 'value');
	}

	/**
	 * @test
	 * @return void
	 */
	public function staticMap(): void
	{
		$text = new Text('Hello #p[property] #p[currency]');

		$text->repository()->provide(StaticDataMap::class);

		$text->on('p')->do(function($fragment, $repository) {
			return $repository->get($fragment->arguments()->get(0));
		});

		$this->assertEquals(
			'Hello static value DKK',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function constructor(): void
	{
		$map = new ConstructorDataMap('John Doe');
		$text = new Text('Hello #p[value]!');

		$text->on('p')->do(function($fragment, $repository) {
			return $repository->get($fragment->arguments()->get(0));
		});

		$text->repository()->provide($map);

		$this->assertEquals(
			'Hello John Doe!',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function global(): void
	{
		Text::global()->repository()->set('hello', 'world');

		$this->assertEquals(
			'world',
			Text::global()->repository()->get('hello')
		);

		$text = new Text('Hello #p[hello]!');

		$this->assertEquals(
			'Hello world!',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function overrideGlobal(): void
	{
		Text::global()->repository()->set('hello', 'world');

		$this->assertEquals(
			'world',
			Text::global()->repository()->get('hello')
		);

		$text = new Text('Hello #p[hello]!');

		$text->repository()->set('hello', 'override');

		$this->assertEquals(
			'Hello override!',
			$text->parse()
		);
	}
}