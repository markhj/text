<?php

namespace Markhj\Text\Test;

use Markhj\Text\Text;
use Markhj\Text\Assets\ExpressionPattern;
use PHPUnit\Framework\TestCase;

class ChangePatternTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$pattern = new ExpressionPattern(
			prefix: '_',
			suffix: '^',
			arguments: '()',
			argumentSeparator: ',',
			end: ';'
		);
		$text = new Text('Hello _w^(1,2); world');

		$text->setExpressionPattern($pattern);

		$this->assertEquals(
			'Hello replaced ["1","2"] world',
			$text
				->on('w')
				->do(function($elm) {
					return 'replaced ' . $elm->expression()->arguments()->toJson();
				})
				->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function playingAround(): void
	{
		$pattern = new ExpressionPattern(
			prefix: '[',
			suffix: ']',
			arguments: '()',
			argumentSeparator: ',',
			end: ';'
		);
		$text = new Text('Hello [method](1,2); world');

		$text
			->setExpressionPattern($pattern)
			->on('method')
			->do(function($elm) {
				return 'replaced';
			});

		$this->assertEquals(
			'Hello replaced world',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function gettingCreative(): void
	{
		$pattern = new ExpressionPattern(
			prefix: '<< ',
			suffix: '',
			arguments: '()',
			argumentSeparator: ',',
			end: ' >>'
		);
		$text = new Text('Hello << method(1,2) >> world');

		$text
			->setExpressionPattern($pattern)
			->on('method')
			->do(function($elm) {
				return 'replaced';
			});

		$this->assertEquals(
			'Hello replaced world',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function common(): void
	{
		$pattern = new ExpressionPattern(
			prefix: '',
			suffix: '',
			arguments: '()',
			argumentSeparator: ',',
			end: ';'
		);
		$text = new Text('Hello method(1,2); world');

		$text
			->setExpressionPattern($pattern)
			->on('method')
			->do(function($elm) {
				return 'replaced';
			});

		$this->assertEquals(
			'Hello replaced world',
			$text->parse()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function crazyOne(): void
	{
		$text = new Text('Hello FUNC:w&&{1...2...3}Ø->Æ world');
		$pattern = new ExpressionPattern(
			prefix: 'FUNC:',
			suffix: '&&',
			arguments: '{}',
			argumentSeparator: '...',
			end: 'Ø->Æ'
		);

		$text->setExpressionPattern($pattern);

		$this->assertEquals(
			'Hello replaced ["1","2","3"] world',
			$text
				->on('w')
				->do(function($elm) {
					return 'replaced ' . $elm->expression()->arguments()->toJson();
				})
				->parse()
		);
	}
}