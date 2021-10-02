# Convert pattern

This is a rather advanced use case, but very handy for some test cases and migration projects.

You can convert a `Text` instance from one syntax to another using:

```php
$text = new Text('Hello name:()');

$newPattern = new ExpressionPattern(
	prefix: '#',
	arguments: '[]'
);

$text->transform($newPattern);
```

The library will now have translated all valid instances of the native syntax into your custom syntax. You can verify with:

```php
var_dump($text->template()); 	// Hello #name[]
```
