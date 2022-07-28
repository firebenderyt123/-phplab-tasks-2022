<?php

namespace basics;

class BasicsValidator implements BasicsValidatorInterface
{

  public function isMinutesException(int $minute): void
  {
    if (!is_int($minute))
      throw new \InvalidArgumentException('Function only accepts integers. Input was: ' . $minute);
    else if ($minute < 0 || $minute > 60)
      throw new \InvalidArgumentException('Minutes variable accepts only integers from 0 to 60');
  }

  public function isYearException(int $year): void
  {
    if (!is_int($year))
      throw new \InvalidArgumentException('Function only accepts integers. Input was: ' . $year);
    else if ($year < 1900)
      throw new \InvalidArgumentException('Year variable must be greater than or equal to 1900');
  }

  public function isValidStringException(string $input): void
  {
    if (!is_string($input))
      throw new \InvalidArgumentException('Function only accepts strings. Input was: ' . $input);
    else if (strlen($input) != 6)
      throw new \InvalidArgumentException("Input variable's length must be equal 6");
  }

}
