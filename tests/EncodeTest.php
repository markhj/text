<?php

namespace Markhj\Text\Test;

use Markhj\Text\Text;
use PHPUnit\Framework\TestCase;

class EncodeTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function encode(): void
	{
		$this->assertEquals(6, strlen('ÆØÅ'));
		$this->assertEquals(3, mb_strlen('ÆØÅ'));

		$this->assertEquals(3, (new Text('ÆØÅ'))->length());
		$this->assertEquals(6, (new Text('ÆØÅ'))->byteSize());
	}
}