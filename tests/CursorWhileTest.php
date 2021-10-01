<?php

namespace Markhj\Text\Test;

use Markhj\Text\Cursor;
use Markhj\Text\Exceptions\LoopProtectionException;
use PHPUnit\Framework\TestCase;

class CursorWhileTest extends TestCase
{
    /**
     * @test
     */
    public function test(): void
    {
        $cursor = (new Cursor('Hello world'));
        $str = '';

        $cursor->while(function(Cursor $cursor) use(&$str) {
            $str .= $cursor->char();

            $cursor->move(2);
        });

        $this->assertEquals('Hlowrd', $str);
        $this->assertTrue($cursor->ended());
    }

    /**
     * @test
     */
    public function protection(): void
    {
        $this->expectException(LoopProtectionException::class);

        (new Cursor('Hello world'))->while(function(Cursor $cursor) {
            $cursor->rewind();
        });
    }
}
