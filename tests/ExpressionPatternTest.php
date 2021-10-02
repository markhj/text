<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Text\Exceptions\InvalidExpressionPatternException;

class ExpressionPatternTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 */
	public function valid(): void
	{
		$this->expectNotToPerformAssertions();

		new ExpressionPattern;
	}

	/**
	 * @test
	 */
	public function validateArgumentsLength(): void
	{
		$this->expectException(InvalidExpressionPatternException::class);

		new ExpressionPattern(
			arguments: '123'
		);
	}

	/**
	 * @test
	 */
	public function validateArgumentQuotes(): void
	{
		$this->expectException(InvalidExpressionPatternException::class);

		new ExpressionPattern(
			argumentQuotes: []
		);
	}

	/**
	 * @test
	 */
	public function validateArgumentSeparatorLength(): void
	{
		$this->expectException(InvalidExpressionPatternException::class);

		new ExpressionPattern(
			argumentSeparator: '...'
		);
	}

	/**
	 * @test
	 */
	public function validateArgumentSeparatorAndQuoteDifference(): void
	{
		$this->expectException(InvalidExpressionPatternException::class);

		new ExpressionPattern(
			argumentSeparator: ',',
			argumentQuotes: ['.', ',']
		);
	}

	/**
	 * @test
	 */
	public function validateArgumentSeparatorAndParenthesesDifferenceFirst(): void
	{
		$this->expectException(InvalidExpressionPatternException::class);

		new ExpressionPattern(
			arguments: '()',
			argumentSeparator: '('
		);
	}

	/**
	 * @test
	 */
	public function validateArgumentSeparatorAndParenthesesDifferenceLast(): void
	{
		$this->expectException(InvalidExpressionPatternException::class);

		new ExpressionPattern(
			arguments: '()',
			argumentSeparator: ')'
		);
	}

	/**
	 * @test
	 */
	public function validateArgumentQuoteAndParenthesesDifferenceFirst(): void
	{
		$this->expectException(InvalidExpressionPatternException::class);

		new ExpressionPattern(
			arguments: '()',
			argumentQuotes: [',', '(', '*']
		);
	}

	/**
	 * @test
	 */
	public function validateArgumentQuoteAndParenthesesDifferenceLast(): void
	{
		$this->expectException(InvalidExpressionPatternException::class);

		new ExpressionPattern(
			arguments: '()',
			argumentQuotes: [',', ')', '*']
		);
	}
}