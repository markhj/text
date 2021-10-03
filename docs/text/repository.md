# Repository

In this chapter we'll explore the `Repository` object. You should already be a little bit familiar with it. If not, it's recommended to read [Introduction to data](/data/data/) first.
 
## Set
The `set` method adds or changes a key/value pair in the repository. This is a quicker, but less structured, way of submitting data to the repository.

```php
$text->repository()->set('key', 'value');
```

You can supply directly to a namespace with:
```php
$text->repository()->set('name.space.key', 'value');
```

## Provide

## Register
Every instance of `Text` has its own repository, but there's also a global one to which you can register key/value pairs and data maps you want to use everywhere.

### Single instance
```php
$text->repository()->provide(MyFirstDataMap::class)
```

### Global
```php
Text::global()->repository()->provide(MyFirstDataMap::class)
```

### Namespaces
To avoid collisions and build a better data structure, it's recommended to provide [namespace](/data/namespaces). For example:
```php
$text->repository()->in('name.space')->provide(MyFirstDataMap::class);
```

## Provide array
If you pass an array in the `set` method it will automatically be flattened to the dot notation.

```php
$text->repository()->set('customer', [
	'name' => 'John Doe',
	'location' => [
		'country' => 'AT',
	],
]);
```

The above is automatically mapped as:

* customer.name
* customer.location.country

## Methods
### provide
```php
public function provide(string|DataMap $dataMap): Repository
```
Provide a class name (which will then be instantiated) or an already instantiated data map to the repository

### in
```php
public function in(string $namespace): Repository
```
Target a namespace

### root
```php
public function root(): Repository
```
Work from the root of the repository (i.e. not in a namespace)

### merge
```php
public function merge(Repository $repository): Repository
```
Merge another repository into the current

### set
```php
public function set(string $key, string|array $value): Repository
```
### get
```php
public function get(string $key): string
```
### collection
```php
public function collection(): AssociativeCollection
```
Retrieve the contents of the repository (in flat dot notation)
