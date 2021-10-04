<?php

namespace Markhj\Text\Tests\Decoration;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;

class CropTest extends BaseTest
{
	protected $legacy = true;
	
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

		$this->assertEquals(
			'world',
			(string) (new Text('Hello world'))->revise()->crop(6, 5)
		);

		$this->assertEquals(
			'world',
			(string) (new Text('Hello world'))->revise()->crop(6)
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