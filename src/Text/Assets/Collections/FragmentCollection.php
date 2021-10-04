<?php

namespace Markhj\Text\Assets\Collections;

use Markhj\Collection\Collection;
use Markhj\Text\Assets\Fragments\Fragment;

class FragmentCollection extends Collection
{
	public function validate($item): bool
	{
		return get_parent_class($item) == Fragment::class;
	}

	public function glue(): string
	{
		$string = '';

		foreach ($this->all() as $fragment) {
			$string .= $fragment->get();
		}

		return $string;
	}

	public function rebase(): string
	{
		$string = '';

		foreach ($this->all() as $fragment) {
			$string .= $fragment->foundation();
		}

		return $string;
	}
}
