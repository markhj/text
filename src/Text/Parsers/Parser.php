<?php

namespace Markhj\Text\Parsers;

use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Assets\Repository;

abstract class Parser
{
	abstract public function parse(
		Fragment $fragment,
		Repository $repository
	): string;
}
