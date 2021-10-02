<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Cursor;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Collection\AssociativeCollection;

class ArgumentReader extends AssociativeCollection
{
	const CONTEXT_COLLECTING = 0x1;
	const CONTEXT_PENDING_SEPARATOR = 0x2;

	protected Cursor $argCursor;
	protected string $cache;
	protected ?string $context;

	public function __construct(
		protected string $string,
		protected ExpressionPattern $pattern
	) {
		$this->argCursor = new Cursor($this->string);

		$this->explode();
	}

	protected function explode(): void
	{
		$this->nextArgument();

		$this->argCursor->while(function(Cursor $cursor) {
			$this->handleIteration();
		});
	}

	protected function handleIteration(): void
	{
		$char = $this->argCursor->char();

		$this->addToCache();
		$this->modifyContext();
		
		if ($this->shouldAddArgument()) {
			$this->set(
				$this->count(),
				$this->trim($this->cache)
			);
			$this->nextArgument();
		}

		$this->argCursor->next();
	}

	protected function shouldAddArgument(): bool
	{
		$char = $this->argCursor->char();
		$separator = $this->pattern->argumentSeparator();

		if ($this->context != self::CONTEXT_COLLECTING && $char == $separator) {
			return true;
		}

		if ($this->argCursor->position() + 1 == mb_strlen($this->argCursor->get())) {
			return true;
		}

		return false;
	}

	protected function nextArgument(): void
	{
		$this->cache = '';
		$this->context = null;
	}

	protected function modifyContext(): void
	{
		$isQuote = in_array(
			$this->argCursor->char(),
			$this->pattern->argumentQuotes()
		);

		if (!$this->context && $isQuote) {
			$this->context = self::CONTEXT_COLLECTING;
		} else if ($this->context == self::CONTEXT_COLLECTING && $isQuote) {
			$this->context = self::CONTEXT_PENDING_SEPARATOR;
		}
	}

	protected function addToCache(): void
	{
		$separator = $this->pattern->argumentSeparator();
		$char = $this->argCursor->char();

		if (
			(!$this->context || $this->context == self::CONTEXT_COLLECTING)
			&& 
			(
				$char != $separator
				|| ($char == $separator && $this->context == self::CONTEXT_COLLECTING)
			)
		) {
			$this->cache .= $this->argCursor->char();
		}
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
