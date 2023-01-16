# Hell
**Hell syntax is still in development.  
As I didn't write the Parser yet, I didn't think about the actual syntax**  
*sorry for using washed up PHP syntax as common coding language in the Code examples*
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
      private string $var1;
      private Foo $var2;
  
      public function __construct(
           string $var1
           Foo $var2
      ) {
        $this->var1 = $var1;
        $this->var2 = $var2;
      }
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
  
  Functions are also saveable as callables/lambda(-function)s 
  ````PHP
  //common OOP Coding language
  $f = function (): string
  {
    return 'Hello World';
  }
  echo $f();
   
  //Hell
  function Foo(): string
  {
     return 'Hello World';
  }
  $f = Foo;
  echo $f();
  ````
  In Hell, similar to JS, a priorly set variable can be used in a function
  ````PHP
  //common Coding language
  $var2 = 'World'
  $f = function ($var1): string
  {
    return $var1 + $var2;
  }
  echo $f('Hello')
   
  //Hell
  $var2 = 'World'
  function Foo(string $var1): string
  {
      return $var1 + $var2; //can READ AND WRITE $var2 just like that 
  }
  $f = Foo;
  echo $f('Hello');
  ````
  Mostly this should be used in context with "classes"
  ````PHP
  //Hell
  function Foo(string $bar): Foo
  {
      function getBar(): string
      {
          return $bar; //getBar has access to $bar like this a class
      }
      
      function Bar(): Bar
      {
          function getString(): string
          {
              return $bar; //access is 'infinitely' deep
          }
  
          return $this
      }
  
      return $this; 
  }
  $foo = Foo('Hello World');
  echo $foo->getBar(); 
  echo $foo->Bar()->getString(); 
  ````
  I dont want access to go infinitely deep  
  use the ``use ()`` option to restrict access
  ````PHP
  //Hell
  function Foo(string $bar): Foo
  {
      function bar() use ($bar): string
      {
          //has access to $bar
          return $bar;
      }
      
      function defaultString() use (): string
      {
          //doesnt have access to bar
          return 'default hello world'
      }
  
      return $this; 
  }
  $foo = Foo('Hello World');
  echo $foo->bar(); 
  echo $foo->defaultString(); 
  ````
  overloading is possible
  ````PHP
  //Hell
  $bar = 'Hello ';
  function Foo() use ($bar): Foo
  {
      function fBar(): string
      {
          return $bar;
      }
      
      function fBar(string $addition): string
      {
          return $bar + $addition;
      }
  
      return $this; 
  }
  $bar = Foo()->fBar;
  echo $bar(); //calls the first fBar function
  echo $bar('World'); //calls the second fBar function
  ````
  

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
          parent::__construct('someVar');
      }
  }
   
  //Hell
  function Foo(Bar $bar, Bam $bam, Boom $boom): Foo
  {
      extends $bar;
      extends $bam;
      extends $boom;
      extends Kaboom('someVar'); // new Kaboom('someVar')
  
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
  Also its possible to just omit the `$exception` variable
  ````PHP
  //Hell
  try { 
      throw RuntimeException();
  } catch (RuntimeException) { //catches the runtime exception
      //handle code that doesnt need the `$exception` variable
  }
  ````
  And you might say: "thats total bs, wtf did u think when programming this"  
  My answer: "maybe, maybe that is an interesting concept willing to be further investigated and elaborated, maybe it is not an actual problem for code quality"  
  .  
  Also you'd be surprised to see that `trycatch` also has a `finally`.  
  And now your brain is like: _yeah there was something_
  ````PHP
  //common OOP Coding language
  try { 
     throw new \Exception();    
  } finally {
     //do sth
  }
   
  //Hell
  try { 
      throw exception();
  } finally {
    //do sth
  }
  ````
  `finally` is used to do sth after a catch clause
  ````PHP
  //PHP
  try {
    try {
        echo 'throw exception'.PHP_EOL;
        throw new Exception();
    } finally {
        echo 'finally execution'.PHP_EOL;
    }
  } catch (Exception $exception) {
    echo 'caught exception'.PHP_EOL;
  }
  //output:
  //throw exception
  //finally execution
  //caught exception
  
  //a typical example of the usage
  $handle = fopen('sth');
  try {
    fread($handle); //exception may occur
  } finally {
    fclose($handle) //finally runs, even if I can't take care of the Exception
                    //or when it runs completely fine and no exception occurs 
  }
  ````
  The problem with `finally`:  
  `finally` is made for that one specific code that has to play when you catch an exception and after the general code is done  
  `finally` can therefore be replaced by simple code duplication   
  that is why didn't want to implement `finally`  
  _except I found something not entirely different which needed addressing_  
  Hells `finally` is getting executed after there is no shove
  ````php
  //Hell
  try {
    try {
      echo 'executes first';
      $maybeCarryOn = throw exception();
    } finally {
      //nope cant carry on
      echo 'executes third';
      doExitPreperations();
    }
  } catch () { 
    echo 'executes second';
    //no shove here !!!
  }
  echo 'executes fourth';
  ````
 
[//]: # (  The differences:)
[//]: # (  - If a return or throw would be used in a `finally`, the maybe thrown exception would just be voided and be seen as dealt with, and the new action would continue  )
    

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
    

//TODO !!! figure out wtf I all left out and missed