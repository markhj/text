<?php

namespace Markhj\Text\Contracts;

use Markhj\Text\Text;

interface RegistersUse
{
	public function use(
		string $className,
		?string $useOn = null
	): Text;
}
