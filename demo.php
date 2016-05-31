<?php

require(__DIR__ . '/PasswordGenerator.php');

$generator = new PasswordGenerator(__DIR__ . '/top-5000.txt');
echo $generator->phrase(4) . "\n";
echo $generator->phrase_with_special_characters(3) . "\n";
