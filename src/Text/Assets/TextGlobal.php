<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Assets\Repository;

class TextGlobal
{
	protected static Repository $repository;

	public function repository(): Repository
	{
		if (!isset(self::$repository)) {
			self::$repository = new Repository;
		}

		return self::$repository;
	}
}
