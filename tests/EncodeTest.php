<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;

class EncodeTest extends BaseTest
{
	protected $legacy = true;
	
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