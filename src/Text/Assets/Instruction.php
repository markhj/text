<?php

namespace Markhj\Text\Assets;

use Markhj\Text\Text;
use Markhj\Text\Assets\Repository;
use Markhj\Text\Assets\Fragments\Fragment;

class Instruction
{
	protected $action;

	public function __construct(
		protected string|int $index
	) {}

	public function setAction(callable $action): Instruction
	{
		$this->action = $action;

		return $this;
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
