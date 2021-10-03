# Map
```php
public function map(
	callable $action,
	?ExpressionPattern $pattern = null
): Text
```

The `map` method loops over the expressions and replaces them with a output. You can replace them with a modified `Fragment`.

```php
$text = new Text('Hello w:() world g:()!');

$text->map(function(Fragment $fragment) {
	return new TextFragment('(map)');
});

$text->parse(); // Hello (map) world (map)!
```

## See also
* [ForEach](../foreach)
* [Rebase](../rebase)
* [Fragments](/advanced/fragments)