<?php

use TCB\Test\TestObject;

class MyTest extends \PHPUnit_Framework_TestCase
{


    public function setUp()
    {
        $this->object = new TestObject();
    }

    public function tearDown()
    {

    }

    public function testEmpty()
    {
        $stack = array();
        $this->assertEmpty($stack);

        return $stack;
    }

    /**
     * @depends testEmpty
     */
    public function testPush(array $stack)
    {
        array_push($stack, 'foo');

        $this->assertEquals('foo', $stack[count($stack) - 1]);
        $this->assertNotEmpty($stack);

        return $stack;
    }
}
