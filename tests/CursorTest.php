<?php

namespace Markhj\Text\Test;

use Markhj\Text\Text;
use Markhj\Text\Cursor;
use PHPUnit\Framework\TestCase;

/**
 * @todo Trimming instructions on slicing
 */
class CursorTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function test(): void
	{
		$text = new Text('This is a line of text');
		$length = $text->length();
		$cursor = new Cursor($text);

		$this->assertEquals(0, $cursor->position());
		$this->assertEquals($length, $cursor->toEnd()->position());
		$this->assertEquals(0, $cursor->rewind()->position());

		$this->assertTrue($cursor->toEnd()->ended());
		$this->assertFalse($cursor->set($length - 1)->ended());
	}

	/**
	 * @test
	 * @return void
	 */
	public function ended(): void
	{
		$text = new Text('This is a line of text');
		$length = $text->length();
		$cursor = new Cursor($text);

		$this->assertTrue($cursor->toEnd()->ended());
		$this->assertFalse($cursor->set($length - 1)->ended());
	}

	/**
	 * @test
	 * @return void
	 */
	public function contraints(): void
	{
		$text = new Text('This is a line of text');
		$length = $text->length();
		$cursor = new Cursor($text);

		$this->assertEquals($length, $cursor->set(999)->position());
		$this->assertEquals(0, $cursor->set(-999)->position());
	}

	/**
	 * @test
	 * @return void
	 */
	public function selection(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->set(4);

		$this->assertEquals('This', (string) $cursor->selection());

		$cursor->move(3);

		$this->assertEquals(' is', (string) $cursor->selection());
	}

	/**
	 * @test
	 * @return void
	 */
	public function selectionReverse(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->set(4)->move(-3);

		$this->assertEquals('his', (string) $cursor->selection());
	}

	/**
	 * @test
	 * @return void
	 */
	public function selectionConstraints(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->set(4)->move(-300);

		$this->assertEquals('This', (string) $cursor->selection());

		$cursor->set(4)->move(300);

		$this->assertEquals(' is a line of text', (string) $cursor->selection());
	}

	/**
	 * @test
	 * @return void
	 */
	public function slicing(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->set(7)->slice();
		$cursor->move(7)->slice();

		$slices = $cursor->slices();

		$this->assertEquals(3, $slices->count());
		$this->assertEquals('This is', (string) $slices->get(0));
		$this->assertEquals(' a line', (string) $slices->get(1));
		$this->assertEquals(' of text', (string) $slices->get(2));
	}

	/**
	 * @test
	 * @return void
	 */
	public function slicingConstraint(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->set(7)->slice();
		$cursor->move(7)->slice();
		$cursor->toEnd()->slice();

		$slices = $cursor->slices();

		$this->assertEquals(3, $slices->count());
		$this->assertEquals('This is', (string) $slices->get(0));
		$this->assertEquals(' a line', (string) $slices->get(1));
		$this->assertEquals(' of text', (string) $slices->get(2));
	}

	/**
	 * @test
	 * @return void
	 */
	public function move(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$this->assertEquals(2, $cursor->move(2)->position());
		$this->assertEquals(6, $cursor->move('text')->position());
		$this->assertEquals(10, $cursor->move(new Text('text'))->position());
	}

	/**
	 * @test
	 * @return void
	 */
	public function delete(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->delete(5);

		$this->assertEquals(
			'is a line of text',
			$cursor->get()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function deleteConstraints(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->set(4)->delete(500);

		$this->assertEquals(
			'This',
			$cursor->get()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function backspace(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->set(6)->backspace(3);

		$this->assertEquals(
			'This a line of text',
			$cursor->get()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function backspaceConstraint(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->set(5)->backspace(200);

		$this->assertEquals(
			'is a line of text',
			$cursor->get()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function insert(): void
	{
		$text = new Text('This is a line of text');
		$cursor = new Cursor($text);

		$cursor->set(7)->insert('n\'t');

		$this->assertEquals(
			'This isn\'t a line of text',
			$cursor->get()
		);

		$cursor->toEnd()->insert(new Text('.'));

		$this->assertEquals(
			'This isn\'t a line of text.',
			$cursor->get()
		);
	}

	/**
	 * Verify that the cursor position has followed the "typing"
	 * 
	 * @test
	 * @return void
	 */
	public function insertCursorFollows(): void
	{
		$text = new Text('Is this a line of text?');
		$cursor = new Cursor($text);

		$cursor->set(5)->insert('test');

		$this->assertEquals(9, $cursor->position());
	}

	/**
	 * On "delete" the cursor must remain in its place, just like
	 * you hit DELETE on a keyboard
	 * 
	 * @test
	 * @return void
	 */
	public function deleteCursorFollows(): void
	{
		$text = new Text('Is this a line of text?');
		$cursor = new Cursor($text);

		$cursor->set(7)->delete(4);

		$this->assertEquals(7, $cursor->position());
	}

	/**
	 * Verify that the cursor position has followed the backspacing
	 * 
	 * @test
	 * @return void
	 */
	public function backspaceCursorFollows(): void
	{
		$text = new Text('Is this a line of text?');
		$cursor = new Cursor($text);

		$cursor->set(7)->backspace(4);

		$this->assertEquals(3, $cursor->position());
	}

	/**
	 * Test the combination of backspace and insert, and see
	 * if the cursor follows
	 * 
	 * @test
	 * @return void
	 */
	public function backspaceInsertCursorFollows(): void
	{
		$text = new Text('Is this a line of text?');
		$cursor = new Cursor($text);

		$cursor->set(7)->backspace(4)->insert('that');

		$this->assertEquals(
			'Is that a line of text?',
			$cursor->get()
		);
	}
}