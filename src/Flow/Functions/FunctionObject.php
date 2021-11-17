<?php

namespace PHell\Flow\Functions;

class FunctionObject
{
    /**
     * @var FunctionObject[]
     */
    private array $parents = [];

    private ?FunctionObject $stack;


    private array $publicVars = [];
    private array $privateVars = [];
    private array $protectedVars = [];

    private array $publicFunctions = [];
    private array $privateFunctions = [];
    private array $protectedFunctions = [];
    public function getFunction(){}
    public function setFunction(){}

    public function getPublicVariable(string $index)
    {
        $var = $this->publicVars[$index];
        if ($var !== null) {
            return $var;
        }

        foreach ($this->parents as $parent) {
            $var = $parent->getPublicVariable($index);
            if ($var !== null) {
                return $var;
            }
        }
        return null;
    }

    public function getProtectedVariable(string $index)
    {
        $var = $this->protectedVars[$index];
        if ($var !== null) {
            return $var;
        }

        $var = $this->publicVars[$index];
        if ($var !== null) {
            return $var;
        }

        foreach ($this->parents as $parent) {
            $var = $parent->getProtectedVariable($index);
            if ($var !== null) {
                return $var;
            }
        }
        return null;
    }

    public function getPrivateVariable(string $index)
    {
        $var = $this->privateVars[$index];
        if ($var !== null) {
            return $var;
        }

        $var = $this->getProtectedVariable($index);
        if ($var !== null) {
            return $var;
        }

        $var = $this->stack->getPrivateVariable($index);
        if ($var !== null) {
            return $var;
        }

        return null;
    }

    public function setPublicVariable(string $index, $value)
    {
        foreach ($this->parents as $parent) {
            if ($parent->setPublicParentVariable($index, $value)) {
                //parent has variable
                return;
            }
        }
        $this->publicVars[$index] = $value;
        if ($value === null) {
            unset($this->publicVars[$index]);
        }
    }

    /**
     * returns true if it FINDS AND SETS the value
     * otherwise returns false
     */
    public function setPublicParentVariable(string $index, $value): bool
    {
        if (array_key_exists($index, $this->publicVars)) {
            $this->publicVars[$index] = $value;
            if ($value === null) {
                unset($this->publicVars[$index]);
            }
            return true;
        }
        foreach ($this->parents as $parent) {
            if ($parent->setPublicParentVariable($index, $value)) {
                //parent has variable
                return true;
            }
        }
        return false;
    }

    public function setProtectedVariable(string $index, $value)
    {
        if (array_key_exists($index, $this->protectedVars)) {
            $this->protectedVars[$index] = $value;
            if ($value === null) {
                unset($this->publicVars[$index]);
            }
        }
    }
}