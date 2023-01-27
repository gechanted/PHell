# PHell

*//TODO replace by IMAGE*

Hell is a language I ~~made~~ am still figuring out, but mostly done  

PHell is an implementation of Hell in PHP (because im a PHP dev) 

The PHell Runtime is what I actually implemented, which takes a sort of binary of Hell and can execute it  
(the binary is/are PHP classes)  
I actually need to implement the parser, and ~~I hate parsing currently~~ its slightly delayed

**Table of contents**

- Hell - Features and ~~Losses~~ Differences
  - see [Hell.md](/Hell.md)
- Getting Started and PHell
- Code Documentation of the PHell Runtime
  - see [Runtime.md](/Runtime.md)
- future todos I want to implement

### PHell
The PHell Project is seperated into the Runtime and the Parser (which is not yet written)  

Every coding language has a sort of 'binary' version of the code  
The Runtime works with the binary  
In PHell the binary language consists of PHP classes  
//TODO picture of binary code  
Also PHell is coded, so that standard PHP functions can be used from PHP in PHell   
Also in PHell $variables are by default private, functions by default public  //TODO check if functions are default public

### Getting Started

//TODO composer stuff  
//TODO bug warning and ticketsystem link

### Todos
 - **Parser**  
    obviously have to program a parser  
    probably build myself a parsing Framework first
    maybe changes the Syntax I currently have there
    and autoloading and namespacing
 - **IDE Linter**  
    would be neat for developing and is an essential if this language should go viral  
    no idea how hard that would be to program, literally never done this  
 - **(Auto)loading**  
    probably just little adjustments if I've implemented the Parser
 - **Multi-Foreach**  
   Iterates over multiple arrays
 - **Operator specializations**  
   Lets you: 
   ````PHP  
   $object operator $value;
   $date + $dateInterval;
   // with 
   public function `operatorname`operatoring(`overloaded typeOfValue` $value) {}
   public function plusoperatoring(DateInterval $interval) {}
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

Runtime.md
$this shenanigans - document them down - picture
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