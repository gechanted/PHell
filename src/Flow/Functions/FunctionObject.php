<?php

namespace PHell\Flow\Functions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\PHellObjectDatatype;
use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use Phell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use ReflectionFunction;

class FunctionObject extends PHellObjectDatatype implements DataInterface
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
     * provides global functions
     */
    private ?FunctionObject $stack; //runningFunction

    private string $name;

    public function __construct(string $name, ?FunctionObject $stack, ?FunctionObject $origin, ?FunctionParenthesis $parenthesis)
    {
        parent::__construct($name);

        $this->stack = $stack;
        $this->origin = $origin;
        $this->name = $name;

        if ($parenthesis !== null) {
            foreach ($parenthesis->getParameters() as $parameter) {
                $this->privateVars[$parameter->getName()] = $parameter->getData();  // TODO !! check parenthesis
            }
        }
    }

    public function getNames(): array
    {
        $resultArray = [$this->name];
        foreach ($this->parents as $parent) {
            $resultArray = array_merge($resultArray, $parent->getNames());
        }

        return $resultArray;
    }


    public function v() { return $this; }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad { return new DataReturnLoad($this); }


    //TODO this currently doesn't allow Typechecks on Variables
    /** @var DataInterface[] */
    private array $publicVars = [];
    /** @var DataInterface[] */
    private array $privateVars = [];
    /** @var DataInterface[] */
    private array $protectedVars = [];

    /** @var LambdaFunction[] */
    private array $publicFunctions = [];
    /** @var LambdaFunction[] */
    private array $privateFunctions = [];
    /** @var LambdaFunction[] */
    private array $protectedFunctions = [];


    // extend --------------------------------------------
    public bool $SAFETY_CHECK_ON_EXTEND = true; // TODO config

    public function extend(FunctionObject $newParent, CodeExceptionTransmitter $exceptionTransmitter): void
    {
        if ($this->checkExtensionRecursionParents($this) === false) {
            //TODO throw Exception
            return;
        }
        if ($this->SAFETY_CHECK_ON_EXTEND) {
            $thisVars = $this->getAccessibleVars();
            $parentVars = $this->getAccessibleVarsParents();
            $newParentVars = array_merge($newParent->getAccessibleVars(), $newParent->getAccessibleVarsParents());

            $diamondProblems = array_intersect($newParentVars, $parentVars);
            $notSolvedDiamondProblems = array_diff($diamondProblems, $thisVars);

            if (count($notSolvedDiamondProblems) !== 0) {
                // TODO throw Exception
                return;
            }
        }
        $this->parents[] = $newParent;
    }

    /** pls use it rarely, in thought out contexts */
    public function extendWithoutPrecaution(FunctionObject $newParent)
    {
        $this->parents[] = $newParent;
    }

    /** returns false if recursion happens */
    public function checkExtensionRecursion(FunctionObject $object): bool
    {
        return ($object !== $this) || $this->checkExtensionRecursionParents($object);
    }

    /** returns false if recursion happens */
    public function checkExtensionRecursionParents(FunctionObject $object): bool
    {
        foreach ($this->parents as $parent) {
            if ($parent->checkExtensionRecursion($object) === false) {
                return false;
            }
        }
        return true;
    }

    /** @return string[] */
    public function getAccessibleVars(): array
    {
        return array_merge(array_keys($this->protectedVars), array_keys($this->publicVars));
    }

    /** @return string[] */
    public function getAccessibleVarsParents(): array
    {
        $arr = [];
        foreach ($this->parents as $parent) {
            $arr = array_merge($arr, $parent->getAccessibleVars(), $parent->getAccessibleVarsParents());
        }
        return $arr;
    }


    // functions --------------------------------------------

    //normal access
    public function addPublicFunction(LambdaFunction $function): void { $this->publicFunctions[] = $function; }
    public function addProtectedFunction(LambdaFunction $function): void { $this->protectedFunctions[] = $function; }
    public function addPrivateFunction(LambdaFunction $function): void { $this->privateFunctions[] = $function; }


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
                $reflection = new ReflectionFunction($index);
                $functions[] = new PHPLambdaFunction(new PHPFunction($reflection));
            }
        }
        return $functions;
    }

    /**
     * public function priorly declared in running function
     * @return LambdaFunction[]
     */
    public function getObjectPubliclyAvailableFunction(string $index): array
    {
        $functions = array_merge(
            $this->getPublicFunctions($index));

        if ($this->origin !== null) {
            $functions = array_merge($functions, $this->origin->getObjectPubliclyAvailableFunction($index));
        }
        return $functions;
    }


    //VARIABLES --------------------------------------------------------


    /**
     * returns true if it FINDS AND SETS the value
     * otherwise returns false
     */
    private function checkAndSet(array &$array, string $index, ?DataInterface $value): bool
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

    public const VISIBILITY_PRIVATE = 'private';
    public const VISIBILITY_PROTECTED = 'protected';
    public const VISIBILITY_PUBLIC = 'public';

    /** check the origin of that object */
    public function setNormalVar(string $index, ?DataInterface $value, string $visibility = self::VISIBILITY_PRIVATE): bool
    {
        if ($this->checkAndSetOriginatorVar($index, $value) === false) {
            if ($value === null) {
                //TODO throw exception: cant unset a value that's not set
                return true;
            }
            switch ($visibility) {
                case self::VISIBILITY_PRIVATE :
                    $this->privateVars[$index] = $value;
                    break;
                case self::VISIBILITY_PROTECTED:
                    $this->protectedVars[$index] = $value;
                    break;
                case self::VISIBILITY_PUBLIC:
                    $this->publicVars[$index] = $value;
                    break;
                default:
                    throw new ShouldntHappenException();
            }
        }
        return true;
    }

    /** normal var call */
    public function checkAndSetOriginatorVar(string $index, ?DataInterface $value): bool
    {
        // TODO check for special vars like $this and $runningfunction

        $isSet = $this->checkAndSet($this->publicVars, $index, $value) ||
            $this->checkAndSet($this->protectedVars, $index, $value) ||
            $this->checkAndSet($this->privateVars, $index, $value);

        if ($isSet !== false) {
            return true;
        }
        if ($this->origin === null) {
            return false;
        }
        return $this->origin->checkAndSetOriginatorVar($index, $value);
    }

    /** normal var call */
    public function getNormalVar(string $index): ?DataInterface
    {
        if ($index === 'this') {
            //TODO !!! problem: $this might not be >this object<, but a child, and >this object< a parent of that child
            return $this;
        }
        //TODO here add a param for runningfunction
        if (array_key_exists($index, $this->privateVars)) {
            return $this->privateVars[$index];
        }
        if (array_key_exists($index, $this->protectedVars)) {
            return $this->protectedVars[$index];
        }
        if (array_key_exists($index, $this->publicVars)) {
            return $this->publicVars[$index];
        }

        return $this->origin?->getNormalVar($index);
    }



    // call to object

    //call from outside to this object
    public function getObjectPubliclyAvailableVar(string $index): ?DataInterface
    {
        if (array_key_exists($index, $this->publicFunctions)) {
            return $this->publicVars[$index];
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
    public function getPublicAndProtectedVariable(string $index): ?DataInterface
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
            $var = $parent->getPublicAndProtectedVariable($index);
            if ($var !== null) {
                return $var;
            }
        }
        return null;
    }

    public function setPublicAndProtectedVariable(string $index, ?DataInterface $value): bool
    {
        if ($this->checkAndSet($this->protectedVars, $index, $value) ||
            $this->checkAndSet($this->publicVars, $index, $value)) {
            return true;
        }

        foreach ($this->parents as $parent) {
            if ($parent->setPublicAndProtectedVariable($index, $value)) {
                //parent has variable
                return true;
            }
        }
        return false;
    }

//    //call from inside to this object
//    //call to $this->etc
//    //TODO keep? $this->getPublicAndProtectedVariable does that without looking for privates? good or not?
//    public function getObjectInnerVar(string $index)
//    {
//        $var = $this->privateVars[$index];
//        if ($var !== null) {
//            return $var;
//        }
//
//        $var = $this->getPublicAndProtectedVariable($index);
//        if ($var !== null) {
//            return $var;
//        }
//
//        return null;
//    }
//
//    public function setObjectInnerVar(string $index, $value): bool
//    {
//        if ($this->checkAndSet($this->privateVars, $index, $value)) {
//            return true;
//        }
//        if ($this->setPublicAndProtectedVariable($index, $value)) {
//            return true;
//        }
//
//        //TODO maybe throw sth here?
//        $this->privateVars[$index] = $value;
//        if ($value === null) {
//            unset($this->privateVars[$index]);
//        }
//        return true;
//    }


}