<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentWrapperTest extends TestCase
{
    protected $validator;
    protected $functions;

    protected function setUp(): void
    {
        $this->validator = new functions\FunctionsValidator();
        $this->functions = new functions\Functions($this->validator);
    }

    /**
     * @dataProvider negativeDataProvider
     */
    public function testInvalidTypes($arg)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->functions->sayHelloArgumentWrapper($arg);
    }

    public function negativeDataProvider(): array
    {
        return [
            [0.45842],
            [1.2e3],
            [7E-10],
            [1_234.567], // work from php74
            [[1, 2, 3]],
            [['a' => 'b', 'c' => 1]],
            [null],
            [new functions\FunctionsValidator()]
        ];
    }
}
