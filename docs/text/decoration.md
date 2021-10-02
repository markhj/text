# Revise

The `Text::revise` provides a number of useful ways to change a string. For example trimming, cropping or converting to misc. code cases.

## Example

```php
$text = new Text('hello_world');

$text->revise()->studly();

var_dump($text->parse()); // HelloWorld
```

If you want to work on the text without altering the original `Text` object, you can clone it first. For example when using it in a condition.

```php
if ($text->clone()->revise()->trim() == '...') {
	// ...
}
```

## Methods
### crop
`public function crop(int $from, int $length): Decoration`


## trim
```php
public function trim(string $char = ' '): Decoration
```

## trimLeft
```php
public function trimLeft(string $char = ' '): Decoration
```

## trimRight
```php
public function trimRight(string $char = ' '): Decoration
```

## substr
```php
public function substr(int $offset, ?int $length = null): Decoration
```

## studly
```php
public function studly(): Decoration
```

## snakecase
```php
public function snakecase(): Decoration
```

## camelcase
```php
public function camelcase(): Decoration
```