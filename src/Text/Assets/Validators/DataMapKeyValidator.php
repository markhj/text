<?php

namespace Markhj\Text\Assets\Validators;

class DataMapKeyValidator extends Validator
{
	public function validate(string $input): bool
	{
		return preg_match('/^([a-z]+\.){0,}([a-z]+)$/', $input);
	}
}
