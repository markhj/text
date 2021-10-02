<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Assets\ArgumentReader;
use Markhj\Text\Assets\ExpressionPattern;

class ArgumentReaderTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 */
	public function test(): void
	{
		$pattern = new ExpressionPattern;
		$reader = new ArgumentReader(
			'7|8',
			$pattern
		);

		$this->assertEquals(7, $reader->get(0));
		$this->assertEquals(8, $reader->get(1));
	}

	/**
	 * @test
	 */
	public function mix(): void
	{
		$pattern = new ExpressionPattern(argumentSeparator: ',');
		$reader = new ArgumentReader(
			'1, "hello"',
			$pattern
		);

		$this->assertEquals('1', $reader->get(0));
		$this->assertEquals('hello', $reader->get(1));
	}

	/**
	 * @test
	 */
	public function quoted(): void
	{
		$pattern = new ExpressionPattern(argumentSeparator: ',');
		$reader = new ArgumentReader(
			'"7,", "8,"',
			$pattern
		);

		$this->assertEquals(
			'7,',
			$reader->get(0)
		);

		$this->assertEquals(
			'8,',
			$reader->get(1)
		);
	}

	/**
	 * @test
	 */
	public function trimming(): void
	{
		$pattern = new ExpressionPattern;
		$reader = new ArgumentReader(
			'   7   |  8 ',
			$pattern
		);

		$this->assertEquals(7, $reader->get(0));
		$this->assertEquals(8, $reader->get(1));
	}

	/**
	 * @test
	 */
	public function trimAndQuotes(): void
	{
		$pattern = new ExpressionPattern;
		$reader = new ArgumentReader(
			'   "7"  |  "7 "   |  " 8 " ',
			$pattern
		);

		$this->assertEquals(7, $reader->get(0));
		$this->assertEquals('7 ', $reader->get(1));
		$this->assertEquals(' 8 ', $reader->get(2));
	}

	/**
	 * @test
	 */
	public function combinationOfQuotes(): void
	{
		$pattern = new ExpressionPattern;
		$reader = new ArgumentReader(
			'   " 6 "  |  7    |  \' 99 \' ',
			$pattern
		);

		$this->assertEquals(' 6 ', $reader->get(0));
		$this->assertEquals('7', $reader->get(1));
		$this->assertEquals(' 99 ', $reader->get(2));
	}

	/**
	 * @test
	 */
	public function altQuotes(): void
	{
		$pattern = new ExpressionPattern(argumentQuotes: ['X', '*', 'Z']);
		$reader = new ArgumentReader(
			'   X 6 X  |  7    |  * 99 * ',
			$pattern
		);

		$this->assertEquals(' 6 ', $reader->get(0));
		$this->assertEquals('7', $reader->get(1));
		$this->assertEquals(' 99 ', $reader->get(2));
	}

	/**
	 * @test
	 * @return void
	 */
	public function getArgumentQuote(): void
	{
		$pattern = new ExpressionPattern;

		$this->assertEquals(
			'"',
			(new ArgumentReader('', $pattern))->getArgumentQuote('"hello"')
		);

		$this->assertNull(
			(new ArgumentReader('', $pattern))->getArgumentQuote('XhelloX')
		);
	}
}
