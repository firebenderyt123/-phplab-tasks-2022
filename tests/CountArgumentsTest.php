<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{
    protected $validator;
    protected $functions;

    protected function setUp(): void
    {
        $this->validator = new functions\FunctionsValidator();
        $this->functions = new functions\Functions($this->validator);
    }

    public function testEmpty()
    {
        $this->assertEquals(
          $this->generateResult(0, []),
          $this->functions->countArguments()
        );
    }

    /**
     * @dataProvider argDataProvider
     */
    public function testCountArgs($input, $expected)
    {
        $this->assertEquals($expected, $this->functions->countArguments(...$input));
    }

    public function argDataProvider(): array
    {
        return [
            [[''],                       $this->generateResult(1, [''])],
            [['text'],                   $this->generateResult(1, ['text'])],
            [['test', '3'],              $this->generateResult(2, ['test', '3'])],
            [['test', '4'],              $this->generateResult(2, ['test', '4'])],
            [['Hello', 'World'],         $this->generateResult(2, ['Hello', 'World'])],
            [['Only', 'three', 'words'], $this->generateResult(3, ['Only', 'three', 'words'])]
        ];
    }

    private function generateResult($a, $b)
    {
      return [
          'argument_count' => $a,
          'argument_values' => $b,
      ];
    }
}
