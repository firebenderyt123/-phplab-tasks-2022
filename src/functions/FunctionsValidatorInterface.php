<?php

namespace functions;

interface FunctionsValidatorInterface
{
    /**
     * @throws \InvalidArgumentException
     */
    public function isSayHelloArgumentWrapperException($arg): void;

    /**
     * @throws \InvalidArgumentException
     */
    public function isCountArgumentsWrapperException($args): void;
}
