# Static data maps



```php
$text = new Text('Hello p:(property) p:(currency)');

$text->repository()->provide(StaticDataMap::class);
```

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