<?php

namespace PHell\Flow\Functions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Datatypes\PHellObjectDatatype;
use PHell\Flow\Exceptions\ParentRecursionException;
use PHell\Flow\Exceptions\UnsolvedDiamondProblemsException;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Operators\Variable;
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

    //TODO maybe make name nullable cause some objects just arent named => (unnamedObject instanceof unnamedObject = false) for the validator
    public function __construct(string $name, ?FunctionObject $stack, ?FunctionObject $origin, ?NamedDataFunctionParenthesis $parenthesis)
    {
        parent::__construct($name);

        $this->stack = $stack;
        $this->origin = $origin;
        $this->name = $name;

        if ($parenthesis !== null) {
            foreach ($parenthesis->getParameters() as $parameter) {
                $this->setNormalVar($parameter->getName(), $parameter->getData());
                //this can actually overwrite stuff in th origin
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


    public function v(): FunctionObject { return $this; }

    public function phpV() { return $this->v(); }

    //Theoretically should never be called, due to this being a VO and not Easily instantiable like an actual "string"
    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad { return new DataReturnLoad($this); }

    public function dumpValue(): string
    {
        $dump = 'Object<'.$this->name.'> {'.PHP_EOL;
        foreach ($this->publicVars as $name => $var) { $dump .= 'public '.$name.'  '.$var->dumpValue().PHP_EOL; }
        foreach ($this->protectedVars as $name => $var) { $dump .= 'protected '.$name.'  '.$var->dumpValue().PHP_EOL; }
        foreach ($this->privateVars as $name => $var) { $dump .= 'private '.$name.'  '.$var->dumpValue().PHP_EOL; }
        $dump .= PHP_EOL;
        foreach ($this->publicFunctions as $function) { $dump .= 'public '.$this->dumpLambda($function); }
        foreach ($this->protectedFunctions as $function) { $dump .= 'protected '.$this->dumpLambda($function); }
        foreach ($this->privateFunctions as $function) { $dump .= 'private '.$this->dumpLambda($function); }
        $dump .= PHP_EOL.'origin: '. PHP_EOL;
        if ($this->origin !== null) {
            $dump .= $this->origin->dumpValue() . PHP_EOL;
        }
        $dump .= PHP_EOL.'parents: ['. PHP_EOL;
        foreach ($this->parents as $parent) {
            $dump .= $parent->dumpValue().PHP_EOL;
        }
        $dump .= ']'.PHP_EOL;
        $dump .= '}';
        return $dump;
    }

    private function dumpLambda(LambdaFunction $function): string
    {
        return $function->getName().'('.$function->dumpParenthesis().'):'.$function->getParenthesis()->getReturnType()->dumpType().PHP_EOL;
    }

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

    public function extend(FunctionObject $newParent, CodeExceptionHandler $exHandler): ExecutionResult
    {
        if ($this->checkExtensionRecursionParents($this) === false) {
            $exResult = $exHandler->transmit(new ParentRecursionException());
            return new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult()));
        }
        $thisVars = $this->getAccessibleVars();
        $parentVars = $this->getAccessibleVarsParents();
        $newParentVars = array_merge($newParent->getAccessibleVars(), $newParent->getAccessibleVarsParents());

        $diamondProblems = array_intersect($newParentVars, $parentVars);
        $notSolvedDiamondProblems = array_diff($diamondProblems, $thisVars);

        if (count($notSolvedDiamondProblems) !== 0) {
            $exResult = $exHandler->transmit(new UnsolvedDiamondProblemsException());
            return new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult()));
        }
        $this->parents[] = $newParent;
        return new ExecutionResult();
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
                $result[$function->getParenthesis()->getHash()] = $function;
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
                $result[$function->getParenthesis()->getHash()] = $function;
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
                $result[$function->getParenthesis()->getHash()] = $function;
            }
        }
        return $result;
    }

    /**
     * GETS the function(s) of normal function call: f(x)
     * for example: getFile($name)
     * goes up the origin and afterwards the stack
     *
     * @return LambdaFunction[]
     */
    public function getNormalFunction(string $index): array
    {
        $functions = [];

        if ($this->origin !== null) {
            $functions = array_merge($functions, $this->origin->getNormalFunction($index));
        }

        if ($this->stack !== null) {
            $functions = array_merge($functions, $this->stack->getStackFunction($index));
        }

        //search for php functions if the stack is up
        if (function_exists($index)) {
            $reflection = new ReflectionFunction($index);
            $functions[] = new PHPLambdaFunction(new PHPFunction($reflection));
        }

        $functions = array_merge($functions,
            $this->getPublicFunctions($index),
            $this->getProtectedFunctions($index),
            $this->getPrivateFunctions($index));

        return $functions;
    }

    /** @return LambdaFunction[] */
    public function getStackFunction(string $index): array
    {
        $functions = [];
        if ($this->stack !== null) {
            $functions = array_merge($functions, $this->stack->getStackFunction($index));
        }

        $functions = array_merge($functions, $this->getPublicFunctions($index));
        return $functions;
    }

    /**
     * call: $this->f(x)
     * @return LambdaFunction[]
     */
    public function getInnerObjectFunction(string $index): array
    {
        $functions = [];
        foreach ($this->parents as $parent) {
            $functions = array_merge($functions, $parent->getInnerObjectFunction($index));
        }

        $functions = array_merge($functions,
            $this->getProtectedFunctions($index),
            $this->getPublicFunctions($index));

        return $functions;
    }

    /**
     * $someObject->f(x)
     * @return LambdaFunction[]
     */
    public function getObjectPubliclyAvailableFunction(string $index): array
    {
        $functions = [];
        foreach ($this->parents as $parent) {
            $functions = array_merge($functions, $parent->getObjectPubliclyAvailableFunction($index));
        }

        $functions = array_merge($functions, $this->getPublicFunctions($index));
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
        if ($index === Variable::SPECIAL_VAR_THIS) {
            return $this;
        }
        if ($index === Variable::SPECIAL_VAR_ORIGIN) {
            return $this->origin;
        }


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

}