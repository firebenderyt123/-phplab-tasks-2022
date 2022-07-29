<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
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
     public function testInvalidTypes($args)
     {
         $this->expectException(InvalidArgumentException::class);

         $this->functions->countArgumentsWrapper($args);
     }

     public function negativeDataProvider(): array
     {
         return [
             [10],
             [0.45842],
             [true],
             [[1, 2, 3]],
             [['a' => 'b', 'c' => 1]],
             [null],
             [new functions\FunctionsValidator()],
             [[10, 10]],
             [[true, false]],
             [[40, '50']],
             [['cat', 55, 'dog']],
             [['string', 'string again', [1, 2, 'a' => 3]]]
         ];
     }
}
