title PHell


todo  

!! TEST !!

description - this markdown  
 -> features of Hell  
   -> FunctionObjects, CatapultReturns, Exceptions + Handling(shove), TypeConstructs, DoWhile?
 -> structure of PHell  
 -> structure of Runtime and Parser  
 -> structure of this Runtime (Code Documentation)  
 -> a ppp?   
 -> future TODOS (Parser, IDE Linter, namespacing, autoloading)

Operators 
+,-,*,/, %(mod)
, > , < , >= , =< , AND, OR , !
== / === , != / !==

() doesnt need to be implemented here cause thats already given due to being classes, in the Parser though


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