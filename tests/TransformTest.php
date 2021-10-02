<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\Assets\ExpressionPattern;

class TransformTest extends BaseTest
{
	/**
	 * @test
	 */
	public function test(): void
	{
		$original = $this->basicPattern();
		$new = new ExpressionPattern(
			prefix: '<< ',
			suffix: '',
			arguments: '()',
			argumentSeparator: ',',
			argumentQuotes: ['\'', '"'],
			end: ' >>'
		);

		$text = (new Text('Hello #world[]!'))->setExpressionPattern($original);

		$text->on('world')->do(function() {
			return 'world';
		});

		$this->assertEquals(
			'Hello #world[]!',
			$text->template()
		);

		$this->assertEquals(
			'Hello world!',
			$text->parse()
		);

		$text->transform($new);

		$this->assertEquals(
			'Hello << world() >>!',
			$text->template()
		);

		$this->assertEquals(
			'Hello world!',
			$text->parse()
		);
	}

	/**
	 * @test
	 */
	public function withArgs(): void
	{
		$original = $this->basicPattern();
		$new = new ExpressionPattern(
			prefix: '<< ',
			suffix: '',
			arguments: '()',
			argumentSeparator: ',',
			argumentQuotes: ['"', '\''],
			end: ' >>'
		);

		$text = (new Text('Hello #world[John|\'Doe\']!'))->setExpressionPattern($original);

		$text->on('world')->do(function($fragment) {
			$args = $fragment->arguments();

			return $args->get(0) . ' ' . $args->get(1);
		});

		$text->transform($new);

		$this->assertEquals(
			'Hello << world("John", "Doe") >>!',
			$text->template()
		);

		$this->assertEquals(
			'Hello John Doe!',
			$text->parse()
		);
	}
}
