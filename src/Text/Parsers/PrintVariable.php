<?php

namespace Markhj\Text\Parsers;

use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Assets\Repository;
use Markhj\Text\Attributes\DataMap\DefaultParserName;

#[DefaultParserName('p')]
class PrintVariable extends Parser
{
	public function parse(
		Fragment $fragment,
		Repository $repository
	): string
	{
		return $repository->get($fragment->arguments()->get(0));
	}
}
