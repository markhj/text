<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Text\Tests\Parsers\GlobalParser;

class GlobalInstructionsTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		Text::global()->use(GlobalParser::class);

		$this->assertEquals(
			'Hello Global!',
			(new Text('Hello #global[]!'))->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function globalWithKey(): void
	{
		Text::global()->use(GlobalParser::class, 'gbl');

		$this->assertEquals(
			'Hello Global!',
			(new Text('Hello #gbl[]!'))->parse()
		);
	}

	/**
	 * @test
	 */
	public function globalOnDo(): void
	{
		Text::global()->on('gblcustom')->do(function() {
			return 'Custom Global';
		});

		$this->assertEquals(
			'Hello Custom Global!',
			(new Text('Hello #gblcustom[]!'))->parse()
		);
	}

	/**
	 * @test
	 */
	public function expressionPattern(): void
	{
		Text::global()->setExpressionPattern(
			new ExpressionPattern(
				prefix: '*',
				suffix: '',
				arguments: '[]',
				argumentSeparator: '|',
				argumentQuotes: ['\'', '"'],
				end: ''
			)
		);

		$text = new Text('Hello #gbl[] *gbl[]!');

		$text->on('gbl')->do(function() {
			return 'Global';
		});

		$this->assertEquals(
			'Hello #gbl[] Global!',
			$text->parse()
		);
	}
}