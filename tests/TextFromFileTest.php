<?php

namespace Markhj\Text\Tests;

use Markhj\Text\Tests\BaseTest;
use Markhj\Text\TextFromFile;

class TextFromFileTest extends BaseTest
{
	protected $legacy = true;
	
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$text = new TextFromFile(__DIR__ . '/Files/basic.html');

		$text->repository()->set('name', 'John Doe');

		$this->assertEquals(
			'Hello John Doe!',
			(string) $text
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function saveToSameFile(): void
	{
		$path = __DIR__ . '/Files/save.html';

		file_put_contents($path, 'Hello #p[name]!');

		$text = new TextFromFile($path);
		$text->repository()->set('name', 'John Doe');
		$text->save();

		$this->assertEquals(
			'Hello John Doe!',
			file_get_contents($path)
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function saveToNewFile(): void
	{
		$path = __DIR__ . '/Files/save.html';
		$new = __DIR__ . '/Files/save_new.html';

		file_put_contents($path, 'Hello #p[name]!');

		$text = new TextFromFile($path);
		$text->repository()->set('name', 'John Doe');
		$text->save($new);

		$this->assertEquals(
			'Hello #p[name]!',
			file_get_contents($path)
		);

		$this->assertEquals(
			'Hello John Doe!',
			file_get_contents($new)
		);
	}
}