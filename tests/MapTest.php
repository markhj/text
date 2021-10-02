<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\Expression;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Assets\Fragments\ExpressionFragment;
use Markhj\Text\Assets\Fragments\TextFragment;

class MapTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$text = new Text('Hello #w[] world #g[]!');

		$text->map(function(Fragment $fragment) {
			return $fragment->set('mapped');
		});

		$this->assertEquals(
			'Hello mapped world mapped!',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function textFragment(): void
	{
		$text = new Text('Hello #w[] world #g[]!');

		$text->map(function(Fragment $fragment) {
			return new TextFragment('mapped');
		});

		$this->assertEquals(
			'Hello mapped world mapped!',
			$text->parse()
		);
	}
}