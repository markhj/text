<?php

namespace Markhj\Text\Contracts;

use Markhj\Text\Text;
use Markhj\Text\Assets\TextGlobal;

interface RegistersUse
{
	public function use(
		string $className,
		?string $on = null
	): self;

	public function on(
		string $index
	): self;

	public function do(
		callable $action
	): self;
}
