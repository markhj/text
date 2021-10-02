<?php

namespace Markhj\Text\Test;

use Markhj\Text\Text;
use Markhj\Text\Tests\Parsers\GlobalParser;
use PHPUnit\Framework\TestCase;

class GlobalInstructionsTest extends TestCase
{
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
}