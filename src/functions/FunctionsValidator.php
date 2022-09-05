<?php

namespace functions;

class FunctionsValidator implements FunctionsValidatorInterface
{
    public function isSayHelloArgumentWrapperException($arg): void
    {
        if (!is_int($arg) && !is_string($arg) && !is_bool($arg))
            throw new \InvalidArgumentException('Function only accepts integer | string | bool. Input type was: ' . gettype($arg));
    }

    public function isCountArgumentsWrapperException($args): void
    {
        foreach ($args as $arg) {
            if (!is_string($arg))
                throw new \InvalidArgumentException('Function only accepts string. Input type was: ' . gettype($arg));
        }
    }
}
