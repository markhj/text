<?php

namespace Markhj\Text\Test;

use Markhj\Text\Text;
use PHPUnit\Framework\TestCase;

class InitTest extends TestCase
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
}