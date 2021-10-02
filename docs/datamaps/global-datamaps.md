# Using data maps globally

You can apply a data map globally, given that it doesn't take any arguments in its constructor.

## Register
```php
Text::global()->repository()->provide(GlobalDataMap::class);
```

### Namespace
```php
Text::global()->repository()->in('group.subgroup')->provide(GlobalDataMap::class);
```

## Example
### Class
```php
use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;

class GlobalDataMap extends DataMap
{
	#[DataMapKey]
	public string $property = 'static value';

	#[DataMapKey]
	public function domain(): string
	{
		return $_SERVER['HTTP_HOST'];
	}
}
```
### Bootstrapping
```php
Text::global()->repository()->provide(GlobalDataMap::class);
```
### Usage
```php
$text = new Text('You are browsing p:(domain)');

var_dump($text->parse()); 	// You are browsing www.example.com
```
