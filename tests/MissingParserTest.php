<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\Text;
use Markhj\Text\Expression;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Assets\Fragments\ExpressionFragment;
use Markhj\Text\Assets\Fragments\TextFragment;

class MissingParserTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function default(): void
	{
		$text = new Text('Hello #one[] world #two[]!');

		$text->on('one')->do(function() {
			return 'one';
		});

		$this->assertEquals(
			'Hello one world #two[]!',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function changedBehavior(): void
	{
		$text = new Text('Hello #one[] world #two[]!');

		$text->on('one')->do(function() {
			return 'one';
		});

		$text->whenParserIsMissing(function() {
			return '[missing parser]';
		});

		$this->assertEquals(
			'Hello one world [missing parser]!',
			$text->parse()
		);
	}
}