<?php

namespace Markhj\Text\Tests\Decoration;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;

class TrimTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$text = (new Text(' Hello world '));
		$text->revise()->trimLeft();
		$this->assertEquals(
			'Hello world ',
			(string) $text
		);

		$text = (new Text(' Hello world '));
		$text->revise()->trimRight();
		$this->assertEquals(
			' Hello world',
			(string) $text
		);

		$text = (new Text(' Hello world '));
		$text->revise()->trim();
		$this->assertEquals(
			'Hello world',
			(string) $text
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function chars(): void
	{
		$chars = '?';

		$text = (new Text('?Hello world?'));
		$text->revise()->trimLeft($chars);

		$this->assertEquals(
			'Hello world?',
			(string) $text
		);

		$text = (new Text('?Hello world?'));
		$text->revise()->trimRight($chars);

		$this->assertEquals(
			'?Hello world',
			(string) $text
		);

		$text = (new Text('?Hello world?'));
		$text->revise()->trim($chars);

		$this->assertEquals(
			'Hello world',
			(string) $text
		);
	}
}