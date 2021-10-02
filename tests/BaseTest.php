<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Text;
use Markhj\Text\Assets\ExpressionPattern;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
	public function setUp(): void
	{
		if ($this->legacy ?? false) {
			Text::global()->setExpressionPattern($this->basicPattern());
		}
	}

	public function tearDown(): void
	{
		Text::global()->setExpressionPattern(null);
	}

	protected function basicPattern(): ExpressionPattern
	{
		return new ExpressionPattern(
			prefix: '#',
			suffix: '',
			arguments: '[]',
			argumentSeparator: '|',
			argumentQuotes: ['\'', '"'],
			end: ''
		);
	}
}
