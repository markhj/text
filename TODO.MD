# To do

* GLOBAL: "use"
* GLOBAL: instructions

```php

```

## Finishing
* Syntax
* Samples

## Ideas
* Multiple parsers #pluralize|ucfirst[some word]

# Roadmap
* Conditions (if/else)
* Loops
* Traverse on pattern (forEach, map, rebase)
	* For example HTML tags
* Improve Text::use
* Organize tests better
* Ensure everything is covered in test
* Cursor::toNext behavior when not found
* Behavior of studly/camel/snakecase when not found



# Pluralization

Example of template by translator

```
@set locale = da_DK
Hello #plural[{count}|world|worlds]
```
{count} instructs the FunctionSignature to replace with from the data map

```
@set locale = serbian
Hello #plural[{count}|world|worldy|worlds]
```

```
$text = new Text('
	@set locale = da_DK
	Hello #plural[{count}|world|worlds]
');

$text->data()->set('count', 2);

$text->on('plural')->do(Pluralize::class);
```