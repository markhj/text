<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Assets\Repository;
use Markhj\Text\Assets\UseToInstruction;
use Markhj\Text\Assets\Instruction;
use Markhj\Text\Contracts\RegistersUse;
use Markhj\Collection\Collection;

class TextGlobal implements RegistersUse
{
	protected static Repository $repository;
	protected static ?Collection $instructions = null;
	protected ?string $index;

	public function repository(): Repository
	{
		if (!isset(self::$repository)) {
			self::$repository = new Repository;
		}

		return self::$repository;
	}

	public function use(
		string $className,
		?string $on = null
	): TextGlobal
	{
		return $this->pushInstruction(
			(new UseToInstruction)->make($className, $on)
		);
	}

	protected function pushInstruction(Instruction $instruction): TextGlobal
	{
		if (!isset(self::$instructions)) {
			self::$instructions = new Collection;
		}

		self::$instructions->push($instruction);

		return $this;
	}

	public function instructions(): Collection
	{
		return self::$instructions ?? new Collection;
	}

	public function on(string $index): TextGlobal
	{
		$this->index = $index;

		return $this;
	}

	public function do(callable $action): TextGlobal
	{
		return $this->pushInstruction(
			(new Instruction($this->index))->setAction($action)
		);
	}
}
