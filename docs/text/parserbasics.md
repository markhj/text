# Basic parsing

Here we'll give a quick introduction to parsing. You can dig deeper on the topic of parsers in the **Parsers** category.

## Basics
```php
$text = new Text('Hello name:(). How are you?');

$text->on('name')->do(function($fragment, $repository) {
	return 'John Doe';
});

var_dump($text->parse()); // Hello John Doe. How are you?
```

This will output the return value of the function where `name:()` is.

In this text the part `name:()` is known as the **expression**. When the text is interpreted it is broken down to **fragments**. A fragment is either plain text or an expression.

## Arguments

You can supply arguments and use them in the parsing. For example:

```php
$text = new Text('Our company was founded age:(2016) years ago');

$text->on('age')->do(function($fragment, $repository) {
	return date('Y') - $fragment->arguments()->get(0);
});

var_dump($text->parse()); // Our company was founded 5 years ago
```

Of course, depending on when you read this the example may have outdated, but you get the idea.

## Work with data

Data is provided to parsers through [repositories](/text/repository), where you either set key/value pairs or
inject [data maps](/data/data).

You can add data for the parser using:
```php
$text->repository()->set('customer.name', 'John Doe');
```

You can access this value in your parsing function with:
```php
$text = new Text('Hello name:(). How are you?');

$text->on('name')->do(function($fragment, $repository) {
	return $repository->get('customer.name');;
});

$text->repository()->set('customer.name', 'John Doe');

var_dump($text->parse()); // Hello John Doe. How are you?
```

## See also
* [Introduction to data](/data/data)
* [Fragments](/advanced/fragments)
