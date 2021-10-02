<?php

namespace Markhj\Text\Tests\Parsers;

use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Assets\Repository;
use Markhj\Text\Parsers\Parser;
use Markhj\Text\Attributes\DataMap\DefaultParserName;

#[DefaultParserName('global')]
class GlobalParser extends Parser
{
	public function parse(
		Fragment $fragment,
		Repository $repository
	): string
	{
		return 'Global';
	}
}
