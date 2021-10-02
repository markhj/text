<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\Tokenizer;

class TokenizerTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$string = 'Hello #w[] World';
		$tokens = (new Tokenizer)->tokenize($string, $this->basicPattern());

		$this->assertCount(3, $tokens);
		$this->assertFalse($tokens->get(0)->isExpression());
		$this->assertTrue($tokens->get(1)->isExpression());
		$this->assertFalse($tokens->get(2)->isExpression());
		$this->assertEquals('Hello ', (string) $tokens->get(0)->foundation());
		$this->assertEquals('#w[]', (string) $tokens->get(1)->foundation());
		$this->assertEquals(' World', (string) $tokens->get(2)->foundation());

		// Expression patterns must be ommitted, so this result is correct
		$this->assertEquals(
			'Hello  World',
			$tokens->glue()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function advanced(): void
	{
		$string = '#w[] More advanced #g[hello] #y[]#x[] example to try with #t[]';
		$tokens = (new Tokenizer)->tokenize($string, $this->basicPattern());

		$this->assertCount(9, $tokens);
		
		$this->assertTrue($tokens->get(0)->isExpression());
		$this->assertFalse($tokens->get(1)->isExpression());
		$this->assertTrue($tokens->get(2)->isExpression()); 	// #g[hello]
		$this->assertFalse($tokens->get(3)->isExpression()); 	//
		$this->assertTrue($tokens->get(4)->isExpression()); 	// #y[]
		$this->assertFalse($tokens->get(5)->isExpression()); 	// 
		$this->assertTrue($tokens->get(6)->isExpression()); 	// #x[]
		$this->assertFalse($tokens->get(7)->isExpression()); 	// ----
		$this->assertTrue($tokens->get(8)->isExpression()); 	// #t[]

		$this->assertEquals('#w[]', $tokens->get(0)->foundation());
		$this->assertEquals(' More advanced ', $tokens->get(1)->foundation());
		$this->assertEquals('#g[hello]', $tokens->get(2)->foundation());
		$this->assertEquals(' ', $tokens->get(3)->foundation());
		$this->assertEquals('#y[]', $tokens->get(4)->foundation());
		$this->assertEquals('', $tokens->get(5)->foundation());
		$this->assertEquals('#x[]', $tokens->get(6)->foundation());
		$this->assertEquals(' example to try with ', $tokens->get(7)->foundation());
		$this->assertEquals('#t[]', $tokens->get(8)->foundation());

		$this->assertEquals(
			' More advanced   example to try with ',
			$tokens->glue()
		);
	}
}