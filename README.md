## PHell

*//TODO replace by IMAGE*

Hell is a language I ~~made~~ am still figuring out, but mostly done  

PHell is an implementation of Hell in PHP (because im a PHP dev) 

The PHell Runtime is what I actually implemented, which takes a sort of binary of Hell and can execute it  
(the binary is/are PHP classes)  
I actually need to implement the parser, and ~~I hate parsing currently~~ its slightly delayed

**Table of contents**

- Hell - Features and ~~Losses~~ Differences //TODO separate .md
- Getting Started and PHell ecosystem
- Code Documentation of the PHell Runtime //TODO separate .md
- future todos


### Hell  
**Hell syntax is still in development.  
As I didn't write the Parser yet, I didn't think about the actual syntax**  
*sorry for using PHP syntax in the Code examples*  
  - ### Functions and Objects   
    Fuck Classes - they can be functions too
    ````PHP
    //common OOP Coding language
    class Foo 
    {
    }
     
    //Hell
    function Foo()
    {
        return $this;
    }
    ````
    There are no classes in Hell. Function can just return their respective ``$this`` variable and thus imitate a constructor
     ````PHP
    //common OOP Coding language
    class Foo 
    {
        public function __construct(
             string $var1
             Foo $var2
        ) {}
    }
     
    //Hell
    function Foo(string $var1, Foo $var2)
    {
        return $this;
    }
    ````
    but how can there be classes and **class datatypes** if there are no classes  
    ... well the objects have the name of the function, they sprout from.  
    Basically, due to that, everything can be a class now 

  - ### Polymorphism
    **or why did no one do this**  
    * due to unknown reasons, classes in common OOP languages can't extend more than 1 other class  
    * due to unknown reasons, classes in common OOP languages can't extend an object of another (veryfied) class, and always create one  
    
    That ends with Hell, where you can:
    ````PHP
    //common OOP Coding language
    class Foo extends Bar
    {
        public function __construct() {
            parent::__construct('comeVar');
        }
    }
     
    //Hell
    function Foo(Bar $bar, Bam $bam, Boom $boom): Foo
    {
        extends $bar;
        extends $bam;
        extends $boom;
        extends Kaboom(); // new Kaboom()
    
        return $this;
    }
    ````
    //TODO !! definitely a picture to explain this  
    Just want to mention here that extending already existing objects, is a thing that the "common" OOP languages should really implement  
    I think it's good for abstraction and mitigating of resource reallocation  
    **FYI: unless at declaration otherwise specified all ``$variables`` and ``functions`` are declared private**
    

  - ### Catapultreturns 
    You can now exit to a higher level function.  
    ````PHP
    //common OOP Coding language
    function foo(): int
    {
        $functionResult = someFunctionDoingStuffMaybeValidating();
        if ($functionResult === null) {
            return 0;
        }
    }
     
    //Hell
    function foo(): int
    {
        $functionResult = someFunctionDoingStuffMaybeValidating(
            $runningfunction //like $this, a language given variable
                             //representing foo() which is currently executed
        );
    }
    function someFunctionDoingStuffMaybeValidating(
        RunningFunction<int> $ifThisFails
    ) {
        //CODE
        if ($result === null) {
            catapultreturn $ifThisFails 0;
            //catapultreturn Function Returnvalue
        }
        //CODE
    }
    ````
    This should maybe help on some ends with complicated redundant, but not codeawayable statements, like just showed  
    **BEWARE this skips code and maybe an Endhandler or a Logger**  
    //TODO maybe make a sth like finally statement, which cant be skipped

  - ### Exceptions and Handling
    Exceptions are almost as usual.  
    Except they are not. (needed to do that pun)  
    Exceptions don't have a Framework anymore
    Meaning you can make something that suits way better for your Project  
    Or just use a lib  
    The only restriction is the exception cant be a scalar (int, string, float, array)  
    The exception has to be an object
     ````PHP
    //common OOP Coding language
    try { 
       throw new \Exception();    
    } catch (\Exception $exception) {
       //Handling
    }
     
    //Hell
    try { 
        throw $this; // literally throwing $this (an object) 
    } catch (foo $exception) {
        //Handling
    }
    ````
    **shove**  
    Another thing I implemented was the ``shove`` command  
    It returns a value back to the throw point
     ````PHP
    //Hell
    try { 
        $var = throw $this; // literally throwing $this (an object) 
        echo($var); //prints 'Hello World'
    } catch (foo $exception) {
        //Handling
        shove 'Hello World';
        //not executed anymore since shove is kind of a `return` command for the catch
    }
    ````
    You can ``shove`` without a value too, to just skip a thrown exception  
    *many of my inbuild exception throwes just ignore `shove`*
     ````PHP
    //Hell
    try { 
        throw Exception(); //new Exception
        //further execution code
    } catch (Exception $exception) {
        shove; //skip the thrown exception
    }
    ````
    If you want to definitely not want to continue a function after you thrown, you can
     ````PHP
    //Hell
    try { 
        throwOC RuntimeException(); //new Exception
        //not executed
    } catch (Exception $exception) {
        shove; //failing to continue the thrown exception
    }
    //execution resumes here after `shove`
    ````
    Also I added an else for try/catch: 
    ````PHP
    //Hell
    try { 
        throw RuntimeException();
    } catch ($exception) { //without specification catches every possible $exception
    }
    ````
    And you might say: "thats total bs, wtf did u think when programming this"  
    My answer: "maybe, maybe that is an interesting concept willing to be further investigated and elaborated, before it is an actual problem for code quality"
  - ### DatatypeConstructs
    **maybe you know the insanely cool feature of PHP8, that you can write multiple Types as requirement**
      ````PHP
    //common OOP Coding language
    function foo(int|string $var): string|false
    {
        echo $var;
        if ($outputWorked) {
            return $var;
        } else {
            return false;
        }
    }
     
    //Hell
    function foo(<int or string> $var): <string or false>
    {
        echo $var;
        if ($outputWorked) {
            return $var;
        } else {
            return false;
        }
    }
    ````
    The Typeconstruct is always an OR  
    Hell allows ANDs
     ````PHP
    //Hell
    function foo(<(MessageClass1 or MessageClass2) and MessageEndingClass> $var): void 
    {
        //->getMessage() from either MessageClass1 or 2 
        //and ->getEnding() from MessageEndingClass
        echo $var->getMessage() + $var->getEnding();
    }
    ````
    **FYI: I defined => int extends float , float extends string**
  - ### Other stuff I did
    **String multiplier**  
    ``int * string = string``
    ````PHP
    //common Coding language
    $result = '';
    $string = 'Hello World';
    $count = 3;
    for (înt $i = 0; $i < $count; $i++) {
        $result += $string;
    }
     
    //Hell
    $string = 'Hello World';
    $count = 3;
    $result = $count * $string;
    ````
    
    **Times Loop**  
    replaces the good old `fori` loop
     ````PHP
    //common Coding language
    $count = 3;
    for (înt $i = 0; $i < $count; $i++) {
        //code
    }
     
    //Hell
    $count = 3;
    loop ($count) /*times*/ {
        //code
    }
    //or 
    $count times {
        //Code
    }
    ````
    
    **Do-while Loop**  
    a minor 'upgrade' which should be neglected
     ````PHP
    //common Coding language
    while (true) {
         //Code executed before condition
        if (!$condition) {
            break;
        }
        //Code executed after condition
    }
    //Hell
    do {
        //Code executed before condition
    } while($condition) {
        //Code executed after condition
    }
    ````
    

todo

!! TEST !!

description - this markdown  
make describing pictures of the features
 -> features of Hell  
   -> FunctionObjects, CatapultReturns, Exceptions + Handling(shove), TypeConstructs, DoWhile?  
 -> structure of PHell  
 -> structure of Runtime and Parser  
 -> structure of this Runtime (Code Documentation)  
 -> a ppp?   
 -> future TODOS (Parser, IDE Linter, namespacing, autoloading, multi-foreach, simplifications for special types by common operator usage)


!!NAMESPACING AND SUBFUNCTION OBJECT NAMES!!!
make a finally block?

.

.

.

... 
idea: 
```PHP  
// imitate class; 
//
// as a PHP feature (not sure how I would do that in Hell)
//uses a class, probably one which is not an abstract class, 
// by covering the same functions / same Interface as the class before
// example:
// maybe not imitate class but rather implement <class, not an interface> 

class StringMultiplicator {
   
   __construct(private int $times)
   
   public function multiply(string $input)
}

//normally 
class FloatStringMultiplicator extends StringMultiplicator { 

   __construct(private float $times) {
       parent::__construct(0);
   }
   
   //overwriting the function
   public function multiply(string $input)
}

// with imitates 
class FloatStringMultiplicator imitates StringMultiplicator { 

   __construct(private float $times)
   //the parent call is not needed to be unnecessarily done
   //and with big enough objects/many enough objects, resources are saved
   
   //overwriting the function
   public function multiply(string $input)
}



```