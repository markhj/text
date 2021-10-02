<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;

class InitTest extends BaseTest
{
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$text = new Text('Hello world');

		$this->assertEquals(
			'Hello world',
			(string) $text
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function doubled(): void
	{
		$text = new Text(new Text('Hello world'));

		$this->assertEquals(
			'Hello world',
			(string) $text
		);
	}

	/**
	 * @test
	 */
	public function defaultPattern(): void
	{
		$text = new Text('Hello name:()!');

		$text->on('name')->do(function() {
			return 'world';
		});

		$this->assertEquals(
			'Hello world!',
			$text->parse()
		);
	}
}