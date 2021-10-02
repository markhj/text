<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Assets\Instruction;
use Markhj\Text\Parsers\Parser;
use Markhj\Text\Attributes\DataMap\DefaultParserName;
use Markhj\Text\Exceptions\MissingExpressionNameException;
use Markhj\Text\Exceptions\IndexNotSelectedException;
use ReflectionClass;

class UseToInstruction
{
	public function make(
		string $className,
		?string $useOn = null
	): Instruction
	{
		$parser = new $className;
		$on = $useOn ?? $this->getFromAttribute($parser);

		$this->validate($on);

		return (new Instruction($on))
			->setAction(function($fragment, $repository) use ($parser) {
				return $parser->parse($fragment, $repository);
			});
	}

	protected function validate(?string $key): void
	{
		if (!$key) {
			throw new MissingExpressionNameException;
		}
	}

	protected function getFromAttribute(Parser $parser): ?string
	{
		$attributes = (new ReflectionClass($parser))->getAttributes();

		foreach ($attributes as $attribute) {
			if ($attribute->getName() == DefaultParserName::class) {
				return $attribute->newInstance()->getName();
			}
		}

		return null;
	}
}
