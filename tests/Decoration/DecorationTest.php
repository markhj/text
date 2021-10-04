<?php

namespace Markhj\Text\Tests\Decoration;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\Tests\DataMaps\BasicDataMap;
use Markhj\Text\Exceptions\StringNotValidForOperationException;

class DecorationTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function reference(): void
	{
		$text = new Text(' Hello world ');

		$text->revise()->trim();

		$this->assertEquals(
			'Hello world',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function clone(): void
	{
		$text = new Text(' Hello world ');
		$clone = $text->clone();

		$clone->revise()->trim();

		$this->assertEquals(
			' Hello world ',
			$text->parse()
		);

		$this->assertEquals(
			'Hello world',
			$clone->parse()
		);
	}

	/**
	 * @test
	 */
	public function studly(): void
	{
		$this->assertEquals(
			'HelloWorld',
			(string) (new Text('HelloWorld'))->revise()->studly()
		);

		$this->assertEquals(
			'HelloWorld',
			(string) (new Text('helloWorld'))->revise()->studly()
		);

		$this->assertEquals(
			'HelloWorld',
			(string) (new Text('hello_world'))->revise()->studly()
		);
	}

	/**
	 * @test
	 */
	public function studlyInvalid(): void
	{
		$this->expectException(StringNotValidForOperationException::class);

		(new Text('1'))->revise()->studly();
	}

	/**
	 * @test
	 */
	public function snakecase(): void
	{
		$this->assertEquals(
			'hello_world',
			(string) (new Text('HelloWorld'))->revise()->snakecase()
		);

		$this->assertEquals(
			'hello_world',
			(string) (new Text('helloWorld'))->revise()->snakecase()
		);
	}

	/**
	 * @test
	 */
	public function snakecaseInvalid(): void
	{
		$this->expectException(StringNotValidForOperationException::class);

		(new Text('snake_case'))->revise()->snakecase();
	}

	/**
	 * @test
	 */
	public function camelcase(): void
	{
		$this->assertEquals(
			'helloWorld',
			(string) (new Text('hello_world'))->revise()->camelcase()
		);

		$this->assertEquals(
			'helloWorld',
			(string) (new Text('HelloWorld'))->revise()->camelcase()
		);
	}

	/**
	 * @test
	 */
	public function camelcaseInvalid(): void
	{
		$this->expectException(StringNotValidForOperationException::class);

		(new Text('1'))->revise()->camelcase();
	}
}
