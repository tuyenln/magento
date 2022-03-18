<?php

namespace Mage2tv\NonSharedDependency\Example;

class Dependent
{
    private $dependency;

    public function __construct(Dependency $dependency)
    {
        $this->dependency = $dependency;
    }

    public function getDependency(): Dependency
    {
        return $this->dependency;
    }
}
