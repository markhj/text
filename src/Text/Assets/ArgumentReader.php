<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Cursor;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Collection\AssociativeCollection;

class ArgumentReader extends AssociativeCollection
{
	public function __construct(
		protected string $string,
		protected ExpressionPattern $pattern
	) {
		$this->explode($string);
	}

	protected function explode(): void
	{
		$cursor = new Cursor($this->string);
		$context = null;
		$cache = '';
		$i = 0;

		$cursor->while(function(Cursor $cursor) use(&$cache, &$i, &$context) {
			$char = $cursor->char();
			$isQuote = in_array($char, $this->pattern->argumentQuotes());
			$separator = $this->pattern->argumentSeparator();

			if (
				(!$context || $context == 'collecting')
				// && !$isQuote
				&& (
					$char != $separator
					|| ($char == $separator && $context == 'collecting')
				)
			) {
				$cache .= $cursor->char();
			}

			if (!$context && $isQuote) {
				$context = 'collecting';
			} else if ($context == 'collecting' && $isQuote) {
				$context = 'pending_separator';
			}
			
			if (
				($context != 'collecting' && $char == $separator)
				|| ($cursor->position() + 1 == mb_strlen($cursor->get()))
			) {
				$this->set($i, $this->trim($cache));

				$i++;
				$cache = '';
				$context = null;
			}

			$cursor->next();
		});
	}

	public function getArgumentQuote(string $argument): ?string
	{
		$firstChar = $argument[0] ?? '';

		if (in_array($firstChar, $this->pattern->argumentQuotes())) {
			return $firstChar;
		}

		return null;
	}

	public function trim(string $argument): mixed
	{
		$argument = trim($argument);
		$quote = $this->getArgumentQuote($argument);

		return trim($argument, $quote);
	}
}
