<?php

namespace Markhj\Text\Test\Decoration;

use Markhj\Text\Text;
use PHPUnit\Framework\TestCase;

class CropTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$this->assertEquals(
			'Hello',
			(string) (new Text('Hello world'))->revise()->crop(0, 5)
		);

		$this->assertEquals(
			'ello',
			(string) (new Text('Hello world'))->revise()->crop(1, 4)
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function constraint(): void
	{
		$this->assertEquals(
			'world',
			(string) (new Text('Hello world'))->revise()->crop(6, 500)
		);
	}
}