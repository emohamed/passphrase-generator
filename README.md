## PHP password / phrase generator

The passwords are easy to remember and not terribly insecure. 

Example usage:

```php
<?php
$generator = new PasswordGenerator(__DIR__ . '/top-5000.txt');
echo $generator->phrase(4) . "\n";
echo $generator->phrase_with_special_characters(3) . "\n";
?>
```