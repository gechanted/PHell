<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Data\DatatypeValidators\PHellObjectDatatypeValidator;

class FunctionObject extends PHellObjectDatatypeValidator implements DatatypeInterface
{
    /**
     * @var FunctionObject[]
     */
    private array $parents = [];

    /**
     * @var null|FunctionObject
     * that cool js bullshit I'm trying to copy
     * gives access to functions and variables
     * usage of strict limits this
     */
    private ?FunctionObject $origin; //superior, senior

    /**
     * @var FunctionObject|null
     * provides global FUNCTIONS
     */
    private ?FunctionObject $stack; //runningFunction
    private ?FunctionParenthesis $parenthesis; //TODO apparently not implemented!!!

    private string $name;

    public function __construct(string $name, ?FunctionObject $stack, ?FunctionObject $origin, ?FunctionParenthesis $parenthesis)
    {
        parent::__construct($name);

        $this->stack = $stack;
        $this->origin = $origin;
        $this->parenthesis = $parenthesis;
        $this->name = $name;
    }

    public function getNames(): array
    {
        $resultArray = [$this->name];
        foreach ($this->parents as $parent) {
            $resultArray = array_merge($resultArray, $parent->getNames());
        }

        return $resultArray;
    }

    private array $publicVars = [];
    private array $privateVars = [];
    private array $protectedVars = [];

    /** @var LambdaFunction[] */
    private array $publicFunctions = [];
    /** @var LambdaFunction[] */
    private array $privateFunctions = [];
    /** @var LambdaFunction[] */
    private array $protectedFunctions = [];

    //normal access
    public function setPublicFunction(FunctionObject $function): void { $this->publicFunctions[] = $function; }
    public function setProtectedFunction(FunctionObject $function): void { $this->protectedFunctions[] = $function; }
    public function setPrivateFunction(FunctionObject $function): void { $this->privateFunctions[] = $function; }


    /** @return LambdaFunction[] */
    public function getPrivateFunctions(string $index): array
    {
        $result = [];
        foreach ($this->privateFunctions as $function) {
            if ($function->getName() === $index) {
                $result[] = $function;
            }
        }
        return $result;
    }

    /** @return LambdaFunction[] */
    public function getProtectedFunctions(string $index): array
    {
        $result = [];
        foreach ($this->protectedFunctions as $function) {
            if ($function->getName() === $index) {
                $result[] = $function;
            }
        }
        return $result;
    }

    /** @return LambdaFunction[] */
    public function getPublicFunctions(string $index): array
    {
        $result = [];
        foreach ($this->publicFunctions as $function) {
            if ($function->getName() === $index) {
                $result[] = $function;
            }
        }
        return $result;
    }

    /**
     * callable with $this->
     * @return LambdaFunction[]
     */
    public function getOriginFunction(string $index): array
    {
        $functions = array_merge(
            $this->getPrivateFunctions($index),
            $this->getProtectedFunctions($index),
            $this->getPublicFunctions($index));

        if ($this->origin !== null) {
            $functions = array_merge($functions, $this->origin->getOriginFunction($index));
        }
        return $functions;
    }

    /**
     * public function priorly declared in running function
     * @return LambdaFunction[]
     */
    public function getStackFunction(string $index): array
    {
        $functions = $this->getPublicFunctions($index);

        //allow private (and protected function access?)
        //first impression: no   , why allow private & protected?
        //private classes, only available for the following stack ... idk

        if ($this->stack !== null) {
            array_merge($functions, $this->stack->getStackFunction($index));
        } else {//search for php functions if the stack is up
            if (function_exists($index)) {
                $functions[] = new PHPFunction($index);
            }
        }
        return $functions;
    }


    //VARIABLES --------------------------------------------------------


    /**
     * returns true if it FINDS AND SETS the value
     * otherwise returns false
     */
    private function checkAndSet(array &$array, string $index, $value): bool
    {
        if (array_key_exists($index, $array)) {
            $array[$index] = $value;
            if ($value === null) {
                unset($array[$index]);
            }
            return true;
        }
        return false;
    }

    public function setOriginatorVar(string $index, $value): bool
    {
        if ($this->checkAndSetOriginatorVar($index, $value) === false) {
            $array[$index] = $value;
            if ($value === null) { //if this true, sth weird happened
                unset($array[$index]);
                trigger_error('In File ' . __FILE__ . ' and line ' . __LINE__ . ' sth weird happened');
            }
        }
        return true;
    }

    public function checkAndSetOriginatorVar(string $index, $value): bool
    {
        $isSet = $this->checkAndSet($this->publicVars, $index, $value) ||
            $this->checkAndSet($this->protectedVars, $index, $value) ||
            $this->checkAndSet($this->privateVars, $index, $value);

        if ($isSet === false) {
            if ($this->origin !== null) {
                return $this->origin->checkAndSetOriginatorVar($index, $value);
            }
        }

        return false;
    }

    public function getOriginVar(string $index)
    {
        //TODO if $this return this FunctionObject
        if (array_key_exists($index, $this->privateVars)) {
            return $this->privateVars[$index];
        }
        if (array_key_exists($index, $this->protectedVars)) {
            return $this->protectedVars[$index];
        }
        if (array_key_exists($index, $this->publicVars)) {
            return $this->publicVars[$index];
        }

        if ($this->origin !== null) {
            return $this->origin->getOriginVar($index);
        }
        return null;
    }



    // call to object

    //call from outside to this object
    public function getObjectPubliclyAvailableVar(string $index)
    {
        if (array_key_exists($index, $this->publicFunctions)) {
            return $this->publicFunctions[$index];
        }

        foreach ($this->parents as $parent) {
            $var = $parent->getObjectPubliclyAvailableVar($index);
            if ($var !== null) {
                return $var;
            }
        }
        return null;
    }

    public function setObjectOuterVar(string $index, $value): bool
    {
        if ($this->checkAndSet($this->publicVars, $index, $value)) {
            return true;
        }
        foreach ($this->parents as $parent) {
            if ($parent->setObjectOuterVar($index, $value)) {
                return true; //parent has variable
            }
        }

        return false;
    }

    //call to protected : only in parent available
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

//    public function setProtectedVariable(string $index, $value)
//    {
//        if (array_key_exists($index, $this->protectedVars)) {
//            $this->protectedVars[$index] = $value;
//            if ($value === null) {
//                unset($this->protectedVars[$index]);
//            }
//            return true;
//        }
//        foreach ($this->parents as $parent) {
//            if ($parent->setProtectedParentVariable($index, $value)) {
//                //parent has variable
//                return true;
//            }
//        }
//        if ($this->setObjectOuterVar($index, $value)) {
//            return true;
//        }
//
//        $this->protectedVars[$index] = $value;
//        if ($value === null) {
//            unset($this->protectedVars[$index]);
//        }
//        return true;
//    }

    public function setProtectedParentVariable(string $index, $value): bool
    {
        if (array_key_exists($index, $this->protectedVars)) {
            $this->protectedVars[$index] = $value;
            if ($value === null) {
                unset($this->protectedVars[$index]);
            }
            return true;
        }
        foreach ($this->parents as $parent) {
            if ($parent->setProtectedParentVariable($index, $value)) {
                //parent has variable
                return true;
            }
        }
        return false;
    }

    //call from inside to this object
    //call to $this->etc
    public function getObjectInnerVar(string $index)
    {
        $var = $this->privateVars[$index];
        if ($var !== null) {
            return $var;
        }

        $var = $this->getProtectedVariable($index);
        if ($var !== null) {
            return $var;
        }

        return null;
    }

    public function setObjectInnerVar(string $index, $value): bool
    {
        if ($this->checkAndSet($this->privateVars, $index, $value)) {
            return true;
        }
        if ($this->setProtectedParentVariable($index, $value)) {
            return true;
        }

        //TODO maybe throw sth here?
        $this->privateVars[$index] = $value;
        if ($value === null) {
            unset($this->privateVars[$index]);
        }
        return true;
    }

//    public function setPrivateParentVariable(string $index, $value): bool
//    {
//        if (array_key_exists($index, $this->privateVars)) {
//            $this->privateVars[$index] = $value;
//            if ($value === null) {
//                unset($this->privateVars[$index]);
//            }
//            return true;
//        }
//        foreach ($this->parents as $parent) {
//            if ($parent->setPrivateParentVariable($index, $value)) {
//                //parent has variable
//                return true;
//            }
//        }
//        return false;
//    }

//    public function setPublicVar(string $index, $value): bool
//    {
//        foreach ($this->parents as $parent) {
//            if ($parent->setObjectOuterVar($index, $value)) {
//                return true; //parent has variable
//            }
//        }
//        $this->publicVars[$index] = $value;
//        if ($value === null) {
//            unset($this->publicVars[$index]);
//        }
//        return true;
//    }



}