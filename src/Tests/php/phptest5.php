<?php

$var = 0;

try {
    throw new RuntimeException();
} catch (RuntimeException $var) {
    var_dump($var);
} finally {

}
