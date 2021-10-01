<?php

namespace Markhj\Text\Assets;

class ArrayFlattener
{
	public function flatten(array $array): array
	{
		foreach ($array as $key => &$value) {
			if (is_array($value)) {
				unset($array[$key]);

				foreach ($value as $a => &$b) {
					$array[$key . '.' . $a] = $b;
				}
			}
		}

		return $array;
	}
}
