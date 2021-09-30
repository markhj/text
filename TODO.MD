# Road map

* TokenCollection > Fragment > Expression
* Fix the "levels" between expression, fragment, etc. -- it can be simplified a lot, for sure!!
* Rename "Fragtment" to Expression towards the coder - maybe with a new wrapper class

* Trim arguments so there can be spacing #w[1, 2]
* Quoted arguments (define quote via expression pattern)

* DATA MAP MED ATTRIBUTES

* forEach
* forEach(callable $action, ExpressionPattern $pattern)
* map
* map(callable $action, ExpressionPattern $pattern)

* Parser
* Data map
	* Object injection

* Trim and Crop as instructions

## Later
* Conditions (if/else)
* Loops

# Pattern suggestions
```php
new Text('pluralize(1, 3)');
```

# Data maps

## Basics
```php
$text->maps(MyCustomDataMap::class, AnotherMap::class);
```

```php
$text->map($order)->with(OrderMap::class)->to('order');
$text->map($customer)->with(CustomerMap::class)->to('customer');
```

## Global
```php
TextDefault::maps(GlobalMap::class);
```

## Override a value (global or local)
```php
$text->change('currency', 'GBP');
```

## Class
```php
class MyCustomDataMap extends MyCustomDataMap
{
	#[DataMapKey]
	public function currency()
	{

	}
}
```

## Inheritance

```php
class EmailTemplate extends Text
{
	public function before(): void
	{
		$this->maps(RelevantForEmailMap::class);
	}
}
```

# Parser

```php
$text->
```


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