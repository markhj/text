# Text

## Basic use
You initiate an instance of `Markhj\Text\Text` containing the string you want to work on. The string can be short or long, it's up to you.

```php
use Markhj\Text\Text;

$text = new Text('Hello world');
```

## Parsing
In the above we example we haven't done any manipulation to the string. We'll cover that later. But once you've changed the string and want to retrieve it, you use `Text::parse` or typecast as string.

### *parse* method
```php
$text = new Text('Hello world');

$text->parse(); // Hello world
```

### Typecast
```php
$text = new Text('Hello world');

(string) $text; // Hello world
```
