# ForEach
```php
public function forEach(
	callable $action,
	?ExpressionPattern $pattern = null
): Text
```

`forEach` loops over expressions found in the text. `forEach` can only read, not write. You can extract information about the expressions, such as their signature, arguments and output.

If you want to change the expression in the text, you can use `map` or `rebase`.

## Example
This example will catch `p:name()` and `amount:(order.amount)`.
```php
$text = new Text('Hello p:name(). You owe us amount:(order.amount)');

$text->forEach(function($fragment) {
	var_dump($fragment);
});
```

## See also
* [Map](../map)
* [Rebase](../rebase)
* [Fragments](/advanced/fragments)
