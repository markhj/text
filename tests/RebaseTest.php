<?php

namespace Markhj\Text\Test;

use Markhj\Text\Text;
use Markhj\Text\Expression;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Assets\Fragments\ExpressionFragment;
use Markhj\Text\Assets\Fragments\TextFragment;
use PHPUnit\Framework\TestCase;

class RebaseTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function replaceTextFragment(): void
	{
		$text = new Text('Hello #w[] world #g[]!');

		$text->on('w')->do(function($fragment) {
			return 'w';
		});

		$text->rebase(function(Fragment $fragment) {
			return new TextFragment('text-fragment');
		});

		$this->assertEquals(
			'Hello text-fragment world text-fragment!',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function replaceExpressionFragment(): void
	{
		$text = new Text('Hello #w[] world #g[]!');

		$text->on('w')->do(function($fragment) {
			return 'w';
		});

		$text->rebase(function(Fragment $fragment) {
			return new ExpressionFragment(new Expression('#w[]'));
		});

		$this->assertEquals(
			'Hello w world w!',
			$text->parse()
		);
	}
}