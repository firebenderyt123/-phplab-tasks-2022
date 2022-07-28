<?php

namespace strings;

class Strings implements StringsInterface
{

  public function snakeCaseToCamelCase(string $input): string
  {
    $inp = str_split($input);
    $result = '';
    for ($i = 0; $i < count($inp); $i++) {
      if ($inp[$i] == '_') {
        $result .= strtoupper($inp[++$i]);
      } else {
        $result .= $inp[$i];
      }
    }
    return $result;
  }

  public function mirrorMultibyteString(string $input): string
  {
    $words = explode(' ', $input);
    $result = '';
    foreach ($words as $word) {
      $inp = mb_str_split($word);
      for ($i = count($inp)-1; $i >= 0; $i--) {
        $result .= $inp[$i];
      }
      $result .= ' ';
    }
    $result = mb_substr($result, 0, -1); // remove last space that will be added in cycle before
    return $result;
  }

  public function getBrandName(string $noun): string
  {
    $inp = str_split($noun);
    $result = '';
    if ($inp[0] == $inp[count($inp)-1]) {
      $result = strtoupper($inp[0]) . substr($noun, 1) . substr($noun, 1);
    } else {
      $result = 'The ' . strtoupper($inp[0]) . substr($noun, 1);
    }
    return $result;
  }

}
