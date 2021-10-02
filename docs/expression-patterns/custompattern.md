# Custom pattern

If, for whatever reason, you don't want to use the native syntax, you can create your own. You can either do it on per-object basis or globally for all instances of `Text`.

## Expression pattern
The first step is to create an instance of `Markhj\Text\Assets\ExpressionPattern`. This object defines what the syntax should look like.

Due to the many arguments we recommend using PHP 8's named arguments to construct the class. For example

```php
$pattern = new ExpressionPattern(
	arguments: '()',
	argumentSeparator: ','
);
```

Any arguments not included will resort to default.

### Properties
The properties you can use are:

* `string prefix`
* `string suffix`
* `string arguments`
* `string argumentSeparator`
* `array argumentQuotes`
* `string end`

When the constructor is called a few validations are carried out. Certain arguments are not allowed to be identical, for example argument separator and argument quotes.

A few arguments also have a fixed length. For example `$arguments` which must be exaxtly 2 characters.

## Single instance

If you want to use your new pattern on select instances of `Text` you apply it using `Text::setExpressionPattern`.

```php
$text = new Text('Hello #name[]');
$pattern = new ExpressionPattern(
	prefix: '#',
	arguments: '[]'
);

$text->setExpressionPattern($pattern);

var_dump($text->parse()); 	// Will be parsed with your new pattern
```

## Global

You can also apply your new expression globally. If you're already widely using this library in your project we advise to do this with caution! It may break parsing mechanisms in other places.

Put this code at the bootstrapping part of your application:

```php
$myNewPattern = new ExpressionPattern(
	prefix: '#',
	arguments: '[]'
);

Text::global()->setExpressionPattern($myNewPattern);
```
