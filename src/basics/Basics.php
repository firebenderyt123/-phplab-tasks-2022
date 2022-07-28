<?php

namespace basics;

class Basics implements BasicsInterface
{

  private $validator;

  public function __construct($validator)
  {
    $this->validator = $validator;
  }

  public function getMinuteQuarter(int $minute): string
  {
    $this->validator->isMinutesException($minute);

    if ($minute > 45 || $minute == 0)
    {
      return "fourth";
    }
    else if ($minute > 30)
    {
      return "third";
    }
    else if ($minute > 15) {
      return "second";
    }
    else
    {
      return "first";
    }
  }

  public function isLeapYear(int $year): bool
  {
    $this->validator->isYearException($year);

    if ($year % 400 == 0)
    {
      return true;
    }
    else if ($year % 100 == 0)
    {
      return false;
    }
    else if ($year % 4 == 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  public function isSumEqual(string $input): bool
  {
    $this->validator->isValidStringException($input);

    if ($input[0] + $input[1] + $input[2] == $input[3] + $input[4] + $input[5])
    {
      return true;
    }
    else
    {
      return false;
    }
  }

}
