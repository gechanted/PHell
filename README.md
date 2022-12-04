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
 -> future TODOS (Parser, IDE Linter)

StdFunctions   
Reflections??  
dump  

Operators (extendOp) (check Actions for respective OPs)

try, catch + FINALLY (the else of the try catch, often just Exception)  


... 
idea: 
```PHP  
imitate class; 
// as a PHP feature (not sure how I would do that in Hell)
//uses a class, probably one which is not an abstract class, 
// by covering the same functions / same Interface as the class before
// example:
// Data contains Data 
// NamedData contains a Name and the Data
// Due to that: Data is a Subset of NamedData

class DataFunctionParenthesis 
{
    /** @param DataFunctionParenthesisParameter[] $parameters */
    public function __construct(private readonly DatatypeInterface $returnType, private array $parameters = []) {
    }
    
    /** @return DataFunctionParenthesisParameter[] $parameters */
    public function getParameters(): array  { return $this->parameters; }
    public function addParameter(DataFunctionParenthesisParameter $parameter): void   {  $this->parameters[] = $parameter; }

    public function getReturnType(): DatatypeInterface  { return $this->returnType; }
}


class NamedDataFunctionParenthesis extends DataFunctionParenthesis
{
    /** @param NamedDataFunctionParenthesisParameter[] $parameters */
    public function __construct(DatatypeInterface $returnType, private array $parameters = [])  {
        parent::__construct([], $returnType); //give in the return type, overwriting the parameters
    }
    /** @return NamedDataFunctionParenthesisParameter[] $parameters */
    public function getParameters(): array  { return $this->parameters; }
    public function addParameter(DataFunctionParenthesisParameter $parameter): void   {  $this->parameters[] = $parameter; }
}

//=================================
//would be then:

class NamedDataFunctionParenthesis imitates DataFunctionParenthesis
{
    /** @param NamedDataFunctionParenthesisParameter[] $parameters */
    public function __construct(private readonly DatatypeInterface $returnType, private array $parameters = []) {
    }
    
    /** @return NamedDataFunctionParenthesisParameter[] $parameters */
    public function getParameters(): array  { return $this->parameters; }
    public function addParameter(DataFunctionParenthesisParameter $parameter): void   {  $this->parameters[] = $parameter; }

    public function getReturnType(): DatatypeInterface  { return $this->returnType; }
}

```