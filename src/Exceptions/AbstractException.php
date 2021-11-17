<?php
namespace PHell\Exceptions;

use Exception;
use Throwable;

class AbstractException extends Exception
{

    public function __construct($object, int $code = 0, Throwable $previous = null)
    {
        if (is_string($object)) {
            $message = $object;
        } elseif (false) {

        } else {
            $message = 'AHHH!! mb; Send the dump to me or DIY, thx';
            var_dump($object);
        }

        parent::__construct($message, $code, $previous);
    }

    protected function deconstruct($object): string
    {
        if (false) {

        } else {
            $message = 'AHHH!! mb; Send the dump to me or DIY, thx';
            var_dump($object);
        }

        return $message;
    }
}