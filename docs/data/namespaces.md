# Namespaces
Namespaces are useful for grouping related data points with other, and keeping it clear of what's irrelvant. You also avoid collissions, i.e. overwriting data with identical keys.

Namespaces are denoted with dots. For example `customer.location.country.code`.

## Single instance
You can set key/value pairs or data maps on single `Text` instances using:

```php
$text->repository()->in('name.space')->set('key', 'value');
$text->repository()->in('custom.namespace')->provide(CustomDataMap::class);
$text->repository()->in('order')->provide(new OrderDataMap($order));
```

## Global
You can also package global data in namespaces.

For example:
```php
Text::global()->repository()->in('global.namespace')->set('key', 'value');
```
