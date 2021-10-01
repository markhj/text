<?php

namespace Markhj\Text\Tests\Parsers;

use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Assets\Repository;
use Markhj\Text\Parsers\Parser;

class ParserWithoutDefaultName extends Parser
{
	public function parse(
		Fragment $fragment,
		Repository $repository
	): string
	{
		return '';
	}
}
