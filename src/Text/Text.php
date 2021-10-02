<?php

namespace Markhj\Text;

use Markhj\Collection\Collection;
use Markhj\Text\Exceptions\IndexNotSelectedException;
use Markhj\Text\Exceptions\MissingExpressionNameException;
use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Assets\Collections\UseCollection;
use Markhj\Text\Assets\Instruction;
use Markhj\Text\Assets\ExpressionPattern;
use Markhj\Text\Assets\FragmentCollection;
use Markhj\Text\Assets\Repository;
use Markhj\Text\Assets\TextGlobal;
use Markhj\Text\Assets\UseToInstruction;
use Markhj\Text\Parsers\Parser;
use Markhj\Text\Parsers\PrintVariable;
use Markhj\Text\Attributes\DataMap\DefaultParserName;
use Markhj\Text\Traits\HandlesInstructions;
use Markhj\Text\Contracts\RegistersUse;
use ReflectionClass;

class Text implements RegistersUse
{
	protected string $template;
	protected ?ExpressionPattern $expressionPattern = null;
	protected Repository $repository;
	protected $whenMissingParser;
	protected int|string|null $index = null;
	protected Collection $instructions;
	protected UseCollection $useCollection;

	protected static TextGlobal $global;

	public function __construct(
		string $template
	)
	{
		$this->template = $this->encode($template);
		$this->instructions = new Collection;
		$this->repository = new Repository;
		$this->useCollection = new UseCollection;

		$this->whenMissingParser = function(
			Fragment $fragment,
			Repository $repository
		): string {
			return $fragment->foundation();
		};

		$this->use(
			PrintVariable::class
		);

		$this->applyGlobal();
	}

	public function __toString(): string
	{
		return $this->parse();
	}

	protected function applyGlobal(): void
	{
		$this->repository()->merge($this->global()->repository());

		foreach ($this->global()->instructions() as $instruction) {
			$this
				->on($instruction->index())
				->do($instruction->getAction());
		}
	}

	public static function global(): TextGlobal
	{
		if (!isset(self::$global)) {
			self::$global = new TextGlobal;
		}

		return self::$global;
	}

	public function clone(): Text
	{
		return new Text($this->parse());
	}

	public function on(string $index): Text
	{
		$this->index = $index;

		return $this;
	}

	public function do(callable $action): Text
	{
		$instruction = (new Instruction($this->index))->setAction($action);

		$this->instructions->push($instruction);

		return $this;
	}

	public function whenParserIsMissing(callable $action): Text
	{
		$this->whenMissingParser = $action;

		return $this;
	}

	public function set(string $string): Text
	{
		$this->template = $string;

		return $this;
	}

	public function template(): string
	{
		return $this->template;
	}

	public function setExpressionPattern(ExpressionPattern $pattern): Text
	{
		$this->expressionPattern = $pattern;

		return $this;
	}

	public function repository(): Repository
	{
		return $this->repository;
	}

	protected function tokenize(
		?ExpressionPattern $pattern = null
	): FragmentCollection
	{
		$fragments = (new Tokenizer)->tokenize(
			$this->template,
			$pattern ?? $this->expressionPattern
		);

		$handled = [];

		foreach ($this->instructions as $instruction) {
			$handled[] = $instruction->index();

			$fragments->map(function(Fragment $fragment) use($instruction) {
				return $this->handleFragment($fragment, $instruction);
			});
		}

		return $this->handleMissingParser($fragments, $handled);
	}

	protected function handleMissingParser(
		FragmentCollection $fragments,
		array $handled
	): FragmentCollection
	{
		return $fragments->map(function(Fragment $fragment) use($handled) {
			$expression = $fragment->expression();

			if (
				!$expression
				|| in_array($expression->key(), $handled)
			) {
				return $fragment;
			}

			$handler = $this->whenMissingParser;

			return $fragment->set($handler($fragment, $this->repository()));
		});
	}

	public function parse(): string
	{
		return $this->tokenize()->glue();
	}

	public function handleFragment(
		Fragment $fragment,
		Instruction $instruction
	): Fragment
	{
		if ($fragment && $fragment->isExpression()) {
			$expression = $fragment->expression();

			if ($expression->key() === $instruction->index()) {
				$value = $instruction->execute($fragment, $this->repository());

				$fragment->set($value);
			}
		}

		return $fragment;
	}

	public function length(): int
	{
		return mb_strlen($this->parse());
	}

	public function byteSize(): int
	{
		return strlen($this->parse());
	}

	public function encode(string $text): string
	{
		return match (strtolower(mb_detect_encoding($text))) {
			'utf-8' => $text,
			default => utf8_encode($text)
		};
	}

	public function use(
		string $className,
		?string $on = null
	): Text
	{
		$instruction = (new UseToInstruction)->make($className, $on);

		return $this
			->on($instruction->index())
			->do($instruction->getAction());
	}

	public function forEach(
		callable $action,
		?ExpressionPattern $pattern = null
	): Text
	{
		$this
			->tokenize($pattern)
			->filter(function(Fragment $fragment) {
				return $fragment->isExpression();
			})->forEach(function(Fragment $fragment) use($action) {
				$action($fragment);
			});

		return $this;
	}

	protected function iterate(
		callable $action,
		?ExpressionPattern $pattern = null
	): FragmentCollection
	{
		return $this->tokenize($pattern)
			->map(function(Fragment $fragment) use($action): Fragment {
				if (!$fragment->isExpression()) {
					return $fragment;
				}

				return $action($fragment);
			});
	}

	public function rebase(
		callable $action,
		?ExpressionPattern $pattern = null
	): Text
	{
		$this->template = $this->iterate($action, $pattern)->rebase();

		return $this;
	}

	public function map(
		callable $action,
		?ExpressionPattern $pattern = null
	): Text
	{
		$this->template = $this->iterate($action, $pattern)->glue();

		return $this;
	}

	public function revise(): Decoration
	{
		return new Decoration($this);
	}
}
