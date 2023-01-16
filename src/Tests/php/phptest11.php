<?php

try {

    try {

        echo 'throw ex'.PHP_EOL;
        throw new Exception('1');

    } catch (RuntimeException $exception) {
        echo 'caught runex'.PHP_EOL;
    } finally {
        echo 'finally finnish'.PHP_EOL;
//        return;
        throw new Exception('2');
    }

} catch (Exception $exception) {
    echo 'caught ex'.$exception->getMessage().PHP_EOL;
}

try {
    echo 'so';
} finally {
    echo 'oo';
}