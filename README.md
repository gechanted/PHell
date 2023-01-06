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
As I didn't write the Parser yet, i didn't think about the actual syntax**  
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
    
        return $this;
    }
    ````
    //TODO !! definitely a picture to explain this  
    Just want to mention here that extending already existing objects, is a thing that the "common" OOP languages should really implement  
    I think it's good for abstraction and mitigating of resource reallocation
    

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
    The only restriction is the Exception cant be a scalar (int, string, float, array)  
    It has to be an object  
    


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
 -> future TODOS (Parser, IDE Linter, namespacing, autoloading)


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