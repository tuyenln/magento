<?php

namespace Mage2tv\NonSharedDependency\Example;

class Dependency
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
