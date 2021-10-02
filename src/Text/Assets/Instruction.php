<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Text;
use Markhj\Text\Assets\Repository;
use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Exceptions\IndexNotSelectedException;

class Instruction
{
	protected $action;

	public function __construct(
		protected string|int|null $index
	) {
		if (is_null($index)) {
			throw new IndexNotSelectedException;
		}
	}

	public function setAction(callable $action): Instruction
	{
		$this->action = $action;

		return $this;
	}

	public function getAction(): callable
	{
		return $this->action;
	}

	public function index(): string|int
	{
		return $this->index;
	}

	public function execute(
		Fragment $fragment,
		Repository $repository
	): string
	{
		$callable = $this->action;

		return $callable($fragment, $repository);
	}
}
