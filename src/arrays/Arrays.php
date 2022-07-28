<?php

namespace arrays;

class Arrays implements ArraysInterface
{
    public function repeatArrayValues(array $input): array
    {
        $arr = [];
        foreach($input as $num) {
            for ($i = 0; $i < $num; $i++) {
                array_push($arr, $num);
            }
        }
        return $arr;
    }

    public function getUniqueValue(array $input): int
    {
        $unique = 0;
        for ($i = 0; $i < count($input); $i++) {
            $wasBreak = false;
            for ($j = 0; $j < count($input); $j++) {
                if ($input[$i] == $input[$j] && $i != $j) {
                    $wasBreak = true;
                    break;
                }
            }
            if (!$wasBreak && ($input[$i] < $unique || $unique == 0)) {
                $unique = $input[$i];
            }
        }
        return $unique;
    }

    public function groupByTag(array $input): array
    {
        $arr = [];
        $tags = [];
        foreach ($input as $inp) {
            foreach ($inp['tags'] as $tag) {
                if (in_array($tag, $tags)) {
                    array_push($arr[$tag], $inp['name']);
                } else {
                    $arr[$tag] = [$inp['name']];
                    array_push($tags, $tag);
                }
            }
        }
        foreach ($arr as $tag => $array) {
            sort($arr[$tag], SORT_STRING);
        }
        ksort($arr);
        return $arr;
    }
}
