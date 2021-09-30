<?php

namespace Markhj\Text\Test;

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
		$this->assertEquals(
			'Hello world ',
			(string) (new Text(' Hello world '))->leftTrim()
		);

		$this->assertEquals(
			' Hello world',
			(string) (new Text(' Hello world '))->rightTrim()
		);

		$this->assertEquals(
			'Hello world',
			(string) (new Text(' Hello world '))->trim()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function chars(): void
	{
		$chars = '?';

		$this->assertEquals(
			'Hello world?',
			(string) (new Text('?Hello world?'))->leftTrim($chars)
		);

		$this->assertEquals(
			'?Hello world',
			(string) (new Text('?Hello world?'))->rightTrim($chars)
		);

		$this->assertEquals(
			'Hello world',
			(string) (new Text('?Hello world?'))->trim($chars)
		);
	}
}