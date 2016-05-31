<?php

require(__DIR__ . '/PasswordGenerator.php');

$generator = new PasswordGenerator(__DIR__ . '/top-5000.txt');
echo $generator->generate(3);