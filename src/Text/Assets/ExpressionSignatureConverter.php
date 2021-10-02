<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Expression;

class ExpressionSignatureConverter
{
	public function __construct(
		protected Expression $original,
		protected ExpressionPattern $to
	) { }

	public function instance(): Expression
	{
		$to = $this->to;
		$arguments = '';

		foreach ($this->original->arguments() as $value) {
			$quote = $to->argumentQuotes()[0];
			$separator = $to->argumentSeparator();
			$arguments .= ($arguments ? $separator . ' ' : '') . sprintf(
				'%s%s%s',
				$quote,
				$value,
				$quote
			);
		}

		$signature = str_replace(
			[
				':prefix',
				':suffix',
				':name',
				':arg1',
				':arg2',
				':end',
				':arguments',
			],
			[
				$to->prefix(),
				$to->suffix(),
				$this->original->key(),
				$to->arguments()[0],
				$to->arguments()[1],
				$to->end(),
				$arguments,
			],
			':prefix:name:suffix:arg1:arguments:arg2:end'
		);

		return new Expression($signature, $to);
	}
}
