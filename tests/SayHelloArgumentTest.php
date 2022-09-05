<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentTest extends TestCase
{
    protected $validator;
    protected $functions;

    protected function setUp(): void
    {
        $this->validator = new functions\FunctionsValidator();
        $this->functions = new functions\Functions($this->validator);
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testHello($arg, $expected)
    {
        $this->assertEquals($expected, $this->functions->sayHelloArgument($arg));
    }

    public function positiveDataProvider(): array
    {
        return [
            ['World', 'Hello World'],
            ["John! My name's Bob.", "Hello John! My name's Bob."],
            ['\nWorld.', 'Hello \nWorld.'],
            [545, 'Hello 545'],
            [0, 'Hello 0'],
            [0457, 'Hello 303'], //0457 - octal num (in decimal - 303)
            [0o123, 'Hello 83'], // from php81 - it's octal number too
            [0x1a, 'Hello 26'], // 0x1a - hex num (26)
            [0b11111111, 'Hello 255'], // binary num (255)
            [1_234_567, 'Hello 1234567'], // from php74 - decimal
            [-450, 'Hello -450'],
            [53.124, 'Hello 53.124'],
            [true, 'Hello 1'],
            [false, 'Hello '],
            [1=='1', 'Hello 1'],
            [0!=0, 'Hello ']
        ];
    }
}
