<?php

$handle = fopen(__FILE__, 'r+');
fclose($handle);
var_dump($handle);