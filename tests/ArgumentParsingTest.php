<?php

namespace Markhj\Text\Test;

use Markhj\Text\Tokenizer;
use Markhj\Text\Text;
use Markhj\Text\Assets\ExpressionPattern;
use PHPUnit\Framework\TestCase;

class ArgumentParsingTest extends TestCase
{
	/**
	 * @test
	 */
	public function trim(): void
	{
		$fragments = (new Tokenizer)->tokenize('Hello #w[1   | 2 ]');

		$this->assertEquals('1', $fragments->get(1)->arguments()->get(0));
		$this->assertEquals('2', $fragments->get(1)->arguments()->get(1));
	}

	/**
	 * @test
	 */
	public function quoted(): void
	{
		$pattern = new ExpressionPattern(
			argumentSeparator: ','
		);
		$fragments = (new Tokenizer)->tokenize('Hello #w[1, "hello"]', $pattern);

		$this->assertEquals('1', $fragments->get(1)->arguments()->get(0));
		$this->assertEquals('hello', $fragments->get(1)->arguments()->get(1));
	}

	/**
	 * @test
	 */
	public function differentQuoteChars(): void
	{
		$pattern = new ExpressionPattern(
			argumentSeparator: ','
		);
		$fragments = (new Tokenizer)->tokenize('Hello #w[\'1\', "hello"]', $pattern);

		$this->assertEquals('1', $fragments->get(1)->arguments()->get(0));
		$this->assertEquals('hello', $fragments->get(1)->arguments()->get(1));
	}

	/**
	 * @test
	 */
	public function altQuoteChars(): void
	{
		$pattern = new ExpressionPattern(
			argumentSeparator: ',',
			argumentQuotes: ['X']

		);
		$fragments = (new Tokenizer)->tokenize('Hello #w[X1X, hello]', $pattern);

		$this->assertEquals('1', $fragments->get(1)->arguments()->get(0));
		$this->assertEquals('hello', $fragments->get(1)->arguments()->get(1));
	}
}
