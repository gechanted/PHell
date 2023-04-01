# Hell
**Hell syntax is still in development.  
As I didn't write the Parser yet, I didn't think about the actual syntax**  
*sorry for using washed up PHP syntax as common coding language in the Code examples*
- ### Functions and Objects
  Fuck Classes - they can be functions too
  <table><tr><td>

  ````PHP
  //common OOP Coding language
  class Foo 
  {
  }
  
  ````
  </td><td> 
  
  ````PHP
  //Hell
  function Foo()
  {
      return $this;
  }
  ````
  </td></tr> </table> 

  **There are no classes in Hell**. Function can just return their respective ``$this`` variable and thus imitate a constructor
  <table><tr><td>

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
    ````
  
  </td><td>

  ````PHP
  //Hell
  function Foo(string $var1, Foo $var2)
  {
      return $this;
  }
  ```` 
 </td></tr> </table>  

  but how can there be classes and **class datatypes** if there are no classes  
  ... well the objects have the name of the function, they sprout from.  
  Basically, due to that, everything can be a class now  
  .  
  **Functions are also saveable as callables/lambda(-function)s** 
  <table><tr><td>

  ````PHP
  //common OOP Coding language
  $f = function (): string
  {
    return 'Hello World';
  }
  echo $f();
 ````
  </td><td>

  ````PHP   
  //Hell
  function Foo(): string
  {
     return 'Hello World';
  }
  $f = Foo;
  echo $f();
  ````
 </td></tr> </table>

  In Hell, similar to JS, **a priorly set variable can be used in a function**

  <table><tr><td> 

  ````PHP
  //common Coding language
  $var2 = 'World'
  $f = function ($var1): string
  {
    return $var1 + $var2;
  }
  echo $f('Hello')
   ````
  </td><td> 

  ````PHP 
  //Hell
  $var2 = 'World'
  function Foo(string $var1): string
  {
      return $var1 + $var2; //can READ AND WRITE $var2 just like that 
  }
  $f = Foo;
  echo $f('Hello');
  ````
   </td></tr> </table>

  Mostly this should be used in context with "classes"
<table><tr><td>

  ````PHP
//in construction
  //TODO do
 ````
  </td><td> 

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
  </td></tr> </table>

  I dont want access to go infinitely deep  
  **use the ``use ()`` option to restrict access**
<table><tr><td>

  ````PHP
  //in construction
  //TODO do
  ````
  </td><td>

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
 </td></tr> </table>

  ## **OVERLOADING IS POSSIBLE**
  <table><tr><td>

  ````PHP
  ````
  </td><td>

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
   </td></tr> </table>

- ### Polymorphism
  **or why did no one do this**
    * due to unknown reasons, classes in common OOP languages can't extend more than 1 other class
    * due to unknown reasons, classes in common OOP languages can't extend an object of another (veryfied) class, and always create one

  That ends with Hell, where you can do that:  
  ### **extend multiple objects**
<table><tr><td>

  ````PHP
  //common OOP Coding language
  class Foo extends Bar
  {
      public function __construct() {
          parent::__construct('someVar');
      }
  }

  ````
  </td><td>

  ````PHP
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
  </td></tr> </table>

  Extending objects has the advantage of actually abstracting those compared to instantiating classes always anew   
  *also hell currently has no interfaces*   
  **FYI: unless at declaration otherwise specified all ``$variables`` and ``functions`` are declared private**


- ### Catapultreturns
  You can now exit to a higher level function.
  
  <table><tr><td> 

  ````PHP
  //common OOP Coding language
  function foo(): int
  {
      $functionResult = someFunctionDoingStuffMaybeValidating();
      if ($functionResult === null) {
          return 0;
      }
  }
  
   ````
  </td><td>

  ````PHP
   
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
   </td></tr></table>

  This should maybe help on some ends with complicated redundant, but not codeawayable statements, like just showed  
  **BEWARE this skips code and maybe an Endhandler or a Logger**  

[//]: # (  //TODO maybe make a sth like finally statement, which cant be skipped)

- ### Exceptions and Handling
  Exceptions are almost as usual.  
  Except they are not. (needed to do that pun)  
  **Exceptions don't have a Framework anymore**  
  Meaning you can make something that suits way better for your Project  
  Or just use a lib  
  The only restriction is **the exception cant be a scalar** (int, string, float, array)  
  **The exception has to be an object**
  <table><tr><td>

   ````PHP
  //common OOP Coding language
  try { 
     throw new \Exception();    
  } catch (\Exception $exception) {
     //Handling
  }

  ````
  </td><td>
  
  ````PHP 
  //Hell
  try { 
      throw $this; // literally throwing $this (an object) 
  } catch (foo $exception) {
      //Handling
  }
  ````
 </td></tr> </table>

  Also I added an else for try/catch: (since there is **no explicit general exception** you can catch)
  <table><tr><td>

  ````PHP
  //in construction
  //TODO do
  ````
  </td><td>

  ````PHP
  //Hell
  try { 
      throw RuntimeException();
  } catch ($exception) { //without specification catches every possible $exception
  }
  ````
 </td></tr> </table>

  Also its possible to just omit the `$exception` variable
  <table><tr><td> 

  ````PHP
  //in construction
  //TODO do
 ````
  </td><td>

  ````PHP
  //Hell
  try { 
      throw RuntimeException();
  } catch (RuntimeException) { //catches the runtime exception
      //handle code that doesnt need the `$exception` variable
  }
  ````
 </td></tr> </table>

  ### **shove**  
  Another thing I implemented was the ``shove`` command  
  It returns a value back to the throw point

<table><tr><td>

  ````PHP
  //in construction
  //TODO do
  ````
  </td><td>

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
 </td></tr> </table>

  You can ``shove`` without a value too, to just skip a thrown exception  
  *many of my inbuild exception throwes just ignore `shove`*
  <table><tr><td>

  ````PHP
  //in construction
  //TODO do
  ````
  </td><td>

  ````PHP
  //Hell
  try { 
      throw Exception(); //new Exception
      //further execution code
  } catch (Exception $exception) {
      shove; //skip the thrown exception
  }
  ````
  </td></tr> </table>

  If you want to definitely not want to continue a function after you thrown, you can
  <table><tr><td>

  ````PHP
  //in construction
  //TODO do
  ````
  </td><td>

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
   </td></tr> </table>

  And you might say: "thats total bs, wtf did u think when programming this"  
  My answer: "maybe, maybe that is an interesting concept willing to be further investigated and elaborated, maybe it is not an actual problem for code quality"  
  .  

[//]: # (  Also you'd be surprised to see that `trycatch` also has a `finally`.  )

[//]: # (  And now your brain is like: _yeah there was something ... totally forgot that existed_)

[//]: # (  <table><tr><td>)

[//]: # ()
[//]: # (  ````PHP)

[//]: # (  //common OOP Coding language)

[//]: # (  try { )

[//]: # (     throw new \Exception&#40;&#41;;    )

[//]: # (  } finally {)

[//]: # (     //do sth)

[//]: # (  })

[//]: # (    ````)

[//]: # (  </td><td>)

[//]: # (  )
[//]: # (  ````PHP)

[//]: # (  //Hell)

[//]: # (  try { )

[//]: # (      throw exception&#40;&#41;;)

[//]: # (  } finally {)

[//]: # (    //do sth)

[//]: # (  })

[//]: # (  ````)

[//]: # (  </td></tr> </table>)

[//]: # ()
[//]: # (  `finally` is used to do sth after a catch clause)

[//]: # ()
[//]: # (  ````PHP)

[//]: # (  //PHP)

[//]: # (  try {)

[//]: # (    try {)

[//]: # (        echo 'throw exception'.PHP_EOL;)

[//]: # (        throw new Exception&#40;&#41;;)

[//]: # (    } finally {)

[//]: # (        echo 'finally execution'.PHP_EOL;)

[//]: # (    })

[//]: # (  } catch &#40;Exception $exception&#41; {)

[//]: # (    echo 'caught exception'.PHP_EOL;)

[//]: # (  })

[//]: # (  //output:)

[//]: # (  //throw exception)

[//]: # (  //finally execution)

[//]: # (  //caught exception)

[//]: # (  )
[//]: # (  //a typical example of the usage)

[//]: # (  $handle = fopen&#40;'sth'&#41;;)

[//]: # (  try {)

[//]: # (    fread&#40;$handle&#41;; //exception may occur)

[//]: # (  } finally {)

[//]: # (    fclose&#40;$handle&#41; //finally runs, even if I can't take care of the Exception)

[//]: # (                    //or when it runs completely fine and no exception occurs )

[//]: # (  })

[//]: # (  ````)

[//]: # (  )
[//]: # (  The problem with `finally`:  )

[//]: # (  `finally` is made for that one specific code that has to play when you catch an exception and after the general code is done  )

[//]: # (  `finally` can therefore be replaced by simple code duplication   )

[//]: # (  that is why didn't want to implement `finally`  )

[//]: # (  _except I found something not entirely different which needed addressing_  )

[//]: # (  Hells `finally` is getting executed after there is no shove)

[//]: # (  ````php)

[//]: # (  //Hell)

[//]: # (  try {)

[//]: # (    try {)

[//]: # (      echo 'executes first';)

[//]: # (      $maybeCarryOn = throw exception&#40;&#41;;)

[//]: # (    } finally {)

[//]: # (      //nope cant carry on)

[//]: # (      echo 'executes third';)

[//]: # (      //do exit code)

[//]: # (    })

[//]: # (  } catch &#40;&#41; { )

[//]: # (    echo 'executes second';)

[//]: # (    //no shove here !!!)

[//]: # (  })

[//]: # (  echo 'executes fourth';)

[//]: # (  ````)
 
[//]: # (  The differences:)
[//]: # (  - If a return or throw would be used in a `finally`, the maybe thrown exception would just be voided and be seen as dealt with, and the new action would continue  )
    

- ### DatatypeConstructs
  *maybe you know the insanely cool feature of PHP8, that you can write multiple Types as requirement*
  <table><tr><td>
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
   ````
  </td><td>

  ````PHP
   
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
   </td></tr> </table>

  The Typeconstruct is always an OR  
  Hell allows **ANDs and ORs**
  <table><tr><td> 

  ````PHP
  //in construction
  //TODO do
  ````
  </td><td>

  ````PHP
  //Hell
  function foo(<(MessageClass1 or MessageClass2) and MessageEndingClass> $var): void 
  {
      //->getMessage() from either MessageClass1 or 2 
      //and ->getEnding() from MessageEndingClass
      echo $var->getMessage() + $var->getEnding();
  }
  ````
  </td></tr> </table>

[//]: # (  **FYI: I defined => int extends float , float extends string **  )
[//]: # (  //TODO ! fix this behavior, i mean int can extend float but there must be a cast to string, else people will be confused to why their strings are added{calculated} instead of being added{string-chained} ) 

[//]: # (  Also Subfunctions in Binary are named `topfunction:subfunction` as object-types  )
[//]: # (  I hope to simplify that with the parser and some import statements   )
[//]: # (//TODO define the autoloading n stuff )
 
- ### Other stuff I did
  **String multiplier**  
  ``int * string = string``
  
  <table><tr><td> 

  ````PHP
  //common Coding language
  $result = '';
  $string = 'Hello World';
  $count = 3;
  for (înt $i = 0; $i < $count; $i++) {
      $result += $string;
  }
  ````
  </td><td>

  ````PHP
   
  //Hell
  $string = 'Hello World';
  $count = 3;
  $result = $count * $string;
  ````
  </td></tr> </table>

  **Times Loop**  
  replaces the good old `fori` loop
  <table><tr><td>

   ````PHP
  //common Coding language
  $count = 3;
  for (înt $i = 0; $i < $count; $i++) {
      //code
  }
  ````
  </td><td>
  
  ````PHP   
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
 </td></tr> </table>

  **Do-while Loop**  
  now can have 2 Code blocks with do while
  *a minor 'upgrade' which can be ignored*
  <table><tr><td>

   ````PHP
  //common Coding language
  while (true) {
       //Code executed before condition
      if (!$condition) {
          break;
      }
      //Code executed after condition
  }
  ````
  </td><td>

  ````PHP
  //Hell
  do {
      //Code executed before condition
  } while($condition) {
      //Code executed after condition
  }
  ````
  </td></tr> </table>
    

[//]: # (//TODO !!! figure out wtf I all left out and missed)