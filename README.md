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

Operators (instanceof) unsetVar
Stdf()s :   DatatypeDatatype validate and getType

try, catch + FINALLY (the else of the try catch, often just Exception)  

Exceptions? with the input value
.

.

.

... 
idea: 
```PHP  
imitate class; 
// as a PHP feature (not sure how I would do that in Hell)
//uses a class, probably one which is not an abstract class, 
// by covering the same functions / same Interface as the class before
// example:

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