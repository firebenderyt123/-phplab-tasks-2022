<?php

use PHPUnit\Framework\TestCase;

class SayHelloTest extends TestCase
{
    protected $validator;
    protected $functions;

    protected function setUp(): void
    {
        $this->validator = new functions\FunctionsValidator();
        $this->functions = new functions\Functions($this->validator);
    }

    public function testHello()
    {
        $this->assertEquals('Hello', $this->functions->sayHello());
    }
}
