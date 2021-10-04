# Introduction to data
In this chapter we will briefly examine the different ways to can supply and use data (variables) in the `Text` object.

## Repository
A `Text` object is equipped with a `Repository`. When you want to add data for use in parsing, you add it to its repository. You can set values directly or provide so-called data maps.

To add data directly you use:

```php
$text->repository()->set('test', 'example');
```

Here `test` is the key, the `example` is the value.

## Usage
### Print
The native `p` parser will output a variable.

Example:

```php
$text = new Text('Hello p:(customer.name)!');
$text->repository()->set('customer.name', 'John Doe');

var_dump($text->parse()); // Hello John Doe!
```

### Access repository
You can also access the repository in parser functions.

```php
$text = new Text('Hello myfunction:(customer.name)!');

$text->on('myfunction')->do(function($fragment, $repository) {
	return $repository->get('customer.name');
});

$text->repository()->set('customer.name', 'John Doe');

var_dump($text->parse()); // Hello John Doe!
```

## Data maps
We will cover **data maps** in greater depth in the coming articles. But briefly put: Data maps are classes that statically and/or dynamically provide data.

Maybe you have some global information, such as currency, or maybe you want to re-use how you handle orders or customers in emails. There are many use cases for data maps. They come with many advantages such as ensuring integrity, streamlining, reusability, etc.

## How can variables be useful?
* Currency / global data
* Re-usable information which could change (phone, address)
* Order / customer
