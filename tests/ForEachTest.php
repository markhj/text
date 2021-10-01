<?php

namespace Markhj\Text\Test;

use Markhj\Text\Text;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Text\Assets\Fragments\Fragment;
use PHPUnit\Framework\TestCase;

class ForEachTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$text = new Text('Hello #w[] world #g[]!');

		$text->on('w')->do(function() {
			return 'test';
		});

		$text->on('g')->do(function() {
			return 'g';
		});

		$str = '';

		$text->forEach(function(Fragment $fragment) use(&$str) {
			$str .= ($str ? ' * ' : '')
				. $fragment->foundation()
				. ' * '
				. $fragment->get();
		});

		$this->assertEquals(
			'#w[] * test * #g[] * g',
			$str
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function customPattern(): void
	{
		$text = new Text('Hello &w[] world &g[]!');
		$pattern = new ExpressionPattern('&');

		$text->on('w')->do(function() {
			return 'test';
		});

		$text->on('g')->do(function() {
			return 'g';
		});

		$str = '';

		$text->forEach(function(Fragment $fragment) use(&$str) {
			$str .= ($str ? ' * ' : '')
				. $fragment->foundation()
				. ' * '
				. $fragment->get();
		}, $pattern);

		$this->assertEquals(
			'&w[] * test * &g[] * g',
			$str
		);
	}
}