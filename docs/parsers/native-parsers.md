# Native parsers

## Print variable
There's currently just one native parser, named `p` - short for "print". Its task is to output variables provided in the repository.

```php
$text = new Text('Hello p:(variable.name). How are you?');

$text->repository()->set('variable.name', 'John Doe');

$text->parse(); // Hello John Doe. How are you?
```

If a variable isn't present in the repository an empty string is put in its place.