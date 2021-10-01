<?php

namespace Markhj\Text\Assets\Validators;

abstract class Validator
{
	abstract public function validate(string $input): bool;
}
