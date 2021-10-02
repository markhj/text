<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\Parsers\PrintVariable;
use Markhj\Text\DataMap\EmptyDataMap;
use Markhj\Text\Exceptions\MissingExpressionNameException;
use Markhj\Text\Tests\Parsers\ParserWithoutDefaultName;

class ParserTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * Here we test that the default injection of parsers
	 * worked
	 * 
	 * @test
	 * @return void
	 */
	public function default(): void
	{
		$map = (new EmptyDataMap)->set('name', 'John Doe');
		$text = new Text('Hello #p[name]!');

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
	public function missingExpressionName(): void
	{
		$this->expectException(MissingExpressionNameException::class);

		(new Text(''))->use(ParserWithoutDefaultName::class);
	}

	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$map = (new EmptyDataMap)->set('name', 'John Doe');
		$text = new Text('Hello #p[name]!');

		$text->repository()->provide($map);
		$text->use(PrintVariable::class);

		$this->assertEquals(
			'Hello John Doe!',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function altName(): void
	{
		$map = (new EmptyDataMap)->set('name', 'John Doe');
		$text = new Text('Hello #custom[name]!');

		$text->repository()->provide($map);
		$text->use(PrintVariable::class, 'custom');

		$this->assertEquals(
			'Hello John Doe!',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function override(): void
	{
		$map = (new EmptyDataMap)->set('name', 'John Doe');
		$text = new Text('Hello #p[name]!');

		$text->repository()->provide($map);
		$text->use(PrintVariable::class);

		$this->assertEquals(
			'Hello John Doe!',
			$text->parse()
		);

		$text->on('p')->do(function() {
			return 'new';
		});

		$this->assertEquals(
			'Hello new!',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function tokenization(): void
	{
		$text = new Text('Hello #w[1|2]#exclamation[]');

		$text
			->on('w')
			->do(function($fragment) {
				return 'world';
			})
			->do(function($fragment) {
				return strtoupper($fragment->get());
			});

		$text->on('exclamation')->do(function($fragment) {
			return '!';
		});

		$this->assertEquals(
			'Hello WORLD!',
			(string) $text
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function arguments(): void
	{
		$text = new Text('Hello #arg[3]');

		$text
			->on('arg')
			->do(function($fragment) {
				return (string) ($fragment->arguments()->get(0) + 1);
			});

		$this->assertEquals(
			'Hello 4',
			(string) $text
		);
	}
}