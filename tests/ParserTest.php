<?php

namespace Markhj\Text\Test;

use Markhj\Text\Text;
use Markhj\Text\Parsers\Pluralize;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function tokenization(): void
	{
		$text = new Text('Hello #w[1|2]#exclamation[]');

		$text
			->on('w')
			->do(function($fragment) {
				return 'world';
			})
			->do(function($fragment) {
				return strtoupper($fragment->get());
			});

		$text->on('exclamation')->do(function($fragment) {
			return '!';
		});

		$this->assertEquals(
			'Hello WORLD!',
			(string) $text
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function arguments(): void
	{
		$text = new Text('Hello #arg[3]');

		$text
			->on('arg')
			->do(function($fragment) {
				return (string) ($fragment->arguments()->get(0) + 1);
			});

		$this->assertEquals(
			'Hello 4',
			(string) $text
		);
	}
}