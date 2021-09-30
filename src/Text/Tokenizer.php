<?php

namespace Markhj\Text;

use Markhj\Text\Cursor;
use Markhj\Text\Assets\FragmentCollection;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Text\Assets\Fragments\TextFragment;
use Markhj\Text\Assets\Fragments\ExpressionFragment;

class Tokenizer
{
	protected function getExpressions(ExpressionPattern $pattern, string $text): array
	{
		$matches = [];

		preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);

		return $matches[0];
	}

	public function tokenize(
		string $text,
		?ExpressionPattern $pattern = null
	): FragmentCollection
	{
		if (is_null($pattern)) {
			$pattern = new ExpressionPattern;
		}

		$collection = new FragmentCollection;
		$cursor = new Cursor($text);
		$expressions = $this->getExpressions($pattern, $text);

		foreach ($expressions as $i => $expression) {
			$offset = (int) $expression[1];
			$text = $expression[0];

			if ($offset > 0) {
				$collection->push(new TextFragment($cursor->set($offset)->selection()));
			}

			$collection->push(new ExpressionFragment(new Expression($text, $pattern)));
			$cursor->move($text);
		}

		if (!$cursor->ended()) {
			$collection->push(new TextFragment($cursor->toEnd()->selection()));
		}

		return $collection;
	}

	public function glue(FragmentCollection $collection): string
	{
		$string = '';

		foreach ($collection as $fragment) {
			$string .= $fragment->get();
		}

		return $string;
	}
}
