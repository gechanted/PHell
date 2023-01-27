- Statement / Command  
    - Returns
    - operator-writing
    - std functions
- FunctionObject  
- Datatypevalidation  
- algorithms i'm hateful/proud about
- Exceptions & TODO ruling

**How to program a language?**  
That is a question I once googled and then decided to figure it out on my own  
That's how I came up with this:   
from [Command.php](/src/Flow/Main/Command.php)
````php
interface Command
{
  function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult;
````
from [Statement.php](/src/Flow/Main/Statement.php)
````php
interface Statement extends Command
{
  public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad;
````

A Statement gives you a value back and a Command just needs to be executed and gives you nothing back
````php
if ($statement) { //if is a command and gives nothing back*
  $statement = statement(); //the function call is a statement and gives back a value which is saved in the variable
  return; //is a command and gives nothing back*
}
````
That is the foundation of programming.   
A statement which returns value and a command which changes the flow of the statements  
And then (after a month of developing) I realized  
Commands like `break` need to communicate with the structures around it  
and that is best done with a return value like `ExecutionResult`,  
and Statements and Commands always need to adhere to skips like Catapultreturns and Exceptions.  
So the simple _"Statement returns value"_ turned into _"Statement returns Exception, Catapult or Value"_  
Same for the Command. 
At that point it's worthy to refactor, but I was a month in and kept it.  

The respective returns are `ExecutionResult` for `Command` and `ReturnLoad` for `Statement`  
`ExecutionResult` has maybe a `CommandAction` inside which instructs further handling with the Constructs of Functions or Loops  
For example a `BreakAction` would signal that a loop should end, and carry another info of how many loops should be affected (`break 2;`)  
`ReturnLoad` should either be   
a `DataReturnLoad`, which carries Data,  
a `ExceptionReturnLoad`, which carries an ExceptionReturn, which is the return of an exception, which didn't or can't be shoved  
or a `CatapultReturnLoad`, which carries a CatapultReturn.

**Why are you telling me this?**  
This is a Documentation, shut up and learn my failures.  
Also with that info one can write an Operator.  
from [Plus.php](/src/Operators/Plus.php)
````php
class Plus extends EasyStatement
{
    public function __construct(private readonly Statement $s1, private readonly Statement $s2)
    {}

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $rl1 = $this->s1->getValue($currentEnvironment, $exHandler);
        if ($rl1 instanceof DataReturnLoad === false) { return $rl1; }
        $rl2 = $this->s2->getValue($currentEnvironment, $exHandler);
        if ($rl2 instanceof DataReturnLoad === false) { return $rl2; }

        $v1 = $rl1->getData();
        $v2 = $rl2->getData();

        $intValidator = new IntegerType();
        $floatValidator = new FloatType();
        $stringValidator = new StringType();
        if ($intValidator->validate($v1) && $intValidator->validate($v2)) {
            $return = new Intege($v1->v() + $v2->v());

        } elseif ($floatValidator->validate($v1) && $floatValidator->validate($v2)) {
            $return = new Floa($v1->v() + $v2->v());

        } elseif ($stringValidator->validate($v1) && $stringValidator->validate($v2)) {
            $return = new Strin($v1->v() . $v2->v());

        } else {
            $r = $exHandler->handle(new PlusException([$v1, $v2]));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
        }

        return new DataReturnLoad($return);
    }
}
````

An Operator usually extends `EasyStatement` which is just a class that implements the Command interface while also letting us implement the Statement interface  
````php
class Plus extends EasyStatement
````
That is what we will do after we decided which information we need.  
For a Plus we just need 2 Datas  
````php
    public function __construct(private readonly Statement $s1, private readonly Statement $s2)
    {}

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
````
So we require 2 Statements which will give us the Data  
Next up is executing the Statements to get their Data  
This executing is important for the flow of the _Binarycode_
````php
        $rl1 = $this->s1->getValue($currentEnvironment, $exHandler);
        if ($rl1 instanceof DataReturnLoad === false) { return $rl1; }
        $v1 = $rl1->getData();
````
_I just use the abbreviation `s` for statement, `rl` for returnload and `v` for value  
At this point I feel compelled to say: Don't abbreviate kids, it leads to bad code_  

After we execute with `getValue()` we either get usable data, with a `DataReturnLoad` or we just pass it on
````php
        $intValidator = new IntegerType();
        if ($intValidator->validate($v1) && $intValidator->validate($v2)) {
            $return = new Intege($v1->v() + $v2->v());
        } else {
            $r = $exHandler->handle(new PlusException([$v1, $v2]));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
        }
````
We validate that we not only have Data, but also usable Data with a Validator (later further explained)  
and either can fulfill the operation and give back a `DataReturnLoad`  
or throw an Exception (later more to that)

---

