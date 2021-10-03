# Static data maps

A **static data map** is a data map which doesn't require any constructor arguments. They support dynamic values via methods, but they cannot be dependent on constructor arguments.

These data maps are intended to for example provide information about the vendor/company/owner, or possibly about the environment such as locale, currency and domain.

Static maps would not be useful for such things as orders, customers, etc. because there can be many entities with unique values.

## Class
The class would look something like this:

```php
use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;

class StaticDataMap extends DataMap
{
	#[DataMapKey]
	public string $property = 'static value';

	#[DataMapKey]
	public function currency(): string
	{
		if (...) {
			return 'DKK';
		} else {
			return 'SEK';
		}
	}
}
```

Out the `DataMapKey` attribute on properties and methods you can to expose. In the repository the values are mapped to the name of the property/method. So in the above, the output of `currency` would have `currency` as key.

## Usage
```php
$text = new Text('Hello p:(property) p:(currency)');

$text->repository()->provide(StaticDataMap::class);

var_dump($text->parse()); 	// Hello static value DKK
```