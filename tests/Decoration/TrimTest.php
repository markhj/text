<?php

namespace Markhj\Text\Test\Decoration;

use Markhj\Text\Text;
use PHPUnit\Framework\TestCase;

class TrimTest extends TestCase
{
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