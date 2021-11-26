<?php

//false, 0 and '' are also counted as null ...
$var = null ?: false ?: 0 ?: '' ?: 'string' ?: 3 ?: true;


var_dump($var);