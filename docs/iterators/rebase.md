# Rebase
```php
$text = new Text('Hello w:() world g:()!');

$text->map(function(Fragment $fragment) {
	return new TextFragment('(map)');
});

$text->parse(); // Hello (map) world (map)!
```

`rebase` works in somewhat the same way as `map`, but is capable of replacing an existing expression with new one. This allows you, for example, to programmatically replace deprecated expressions/parsers with new ones, according to new business logic.

## Example
```php
$text = new Text('Hello w:() world g:()!');

$text->on('w')->do(function($fragment) {
	return 'w';
});

$text->on('g')->do(function($fragment) {
	return 'g';
});

// Replace instances of "g" parser with "w"
$text->rebase(function(Fragment $fragment) {
	if ($fragment->expression()->key() == 'g') {
		return new ExpressionFragment(new Expression('w:()'));
	}
});

$text->parse();   // Hello w world w!
```