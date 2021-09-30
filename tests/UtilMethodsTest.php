<?php

namespace Markhj\Text\Test;

use Markhj\Text\Text;
use PHPUnit\Framework\TestCase;

class UtilMethodsTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function substr(): void
	{
		$text = new Text('Hello world');

		$this->assertEquals(
			'Hello',
			(string) $text->substr(0, 5)
		);

		$this->assertEquals(
			'world',
			(string) $text->substr(6, 5)
		);

		$this->assertEquals(
			'world',
			(string) $text->substr(6)
		);
	}
}