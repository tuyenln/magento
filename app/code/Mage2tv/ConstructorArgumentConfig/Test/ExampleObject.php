<?php

namespace Mage2tv\ConstructorArgumentConfig\Test;

class ExampleObject
{
    /**
     * @var mixed
     */
    public $example;

    public function __construct($example)
    {
        $this->example = $example;
    }
}
