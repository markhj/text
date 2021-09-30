<?php

namespace Markhj\Text\Assets;

use Markhj\Collection\Collection;
use Markhj\Text\Assets\Fragments\Fragment;

class FragmentCollection extends Collection
{
	public function validate($item): bool
	{
		return get_parent_class($item) == Fragment::class;
	}
}
