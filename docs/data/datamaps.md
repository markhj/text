# Data maps

A **data map** is a class providing data/variables to be used in the parsers. We disntinguish between two types: The normal and the static. The only real difference is that static data maps don't take constructor arguments.

Static maps are used to provide generalized information, for example the name of the website or the currency. The normal data map takes constructor arguments and are for example useful for context-dependent information such as orders, customers or products.

Data maps consist of 

## Basic class
```php
use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;

class MyFirstDataMap extends DataMap
{
	#[DataMapKey]
	public string $property = 'property';

	#[DataMapKey]
	public function method(): string
	{
		return '(example of a method)';
	}
}
```

You can supply properties and methods alike. As you can see, the important thing is that the properties and methods you want to expose for use in parsers are attributed with `DataMapKey`.

## Registration
Great, now we have a data map. What's next? Next is registering the class for use. You can do this to a specific instance of `Text` or globally.

To register for a single instance:
```php
$text->repository()->provide(MyFirstDataMap::class)
```

Or, globally:
```php
Text::global()->repository()->provide(MyFirstDataMap::class)
```

To avoid collisions and build a better data structure, it's recommended to provide namespace, for example:
```php
$text->repository()->in('name.space')->provide(MyFirstDataMap::class);
```

## Usage
Parsers will now have access to the data, in this fashion:

```php
$text = new Text('Hello p:(method)');

$text->repository()->provide(MyFirstDataMap::class);

$text->parse();  // Hello (example of a method)
```

## Constructor arguments
When you work with more context-driven information you want to supply constructor arguments. Let's run with an example of an order.

The class would look like:
```php
use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;
use App\Models\Order;

class OrderDataMap extends DataMap
{
	public function __construct(
		protected Order $order
	) {
		parent::__construct();
	}

	#[DataMapKey]
	public function amount(): string
	{
		return number_format($this->order->total, 2);
	}
}
```

It's very important to always include the `parent::__construct()` line. If you omit this the code is very likely to break.

The smart thing is that since `amount` is a method you can make the output conditional. For example, if the you read on the order that it's Danish you might want to format the number in one way, but if it's American, another.

```php
#[DataMapKey]
public function amount(): string
{
	switch ($this->order->locale) {
		// ...
		
		default:
			return number_format($this->order->amount, 2, ',', '.');
	}
}
```

Example of usage:
```php
$text = new Text('Hello! You have placed an order for p:(order.amount)');

$map = OrderDataMap($order);

$text->repository()->provide($map);

$text->parse();  // Hello! You have placed an order for 299,95
```
