# Parser class

You can create parsers as classes, so you don't have to write out their full functionality every time, and, of course, structure the code more beautifully.

## Class
A bare minimum parser class looks like this:

```php
use Markhj\Text\Parsers\Parser;
use Markhj\Text\Assets\Repository;
use Markhj\Text\Assets\Fragments\Fragment;
use Markhj\Text\Attributes\DataMap\DefaultParserName;

#[DefaultParserName('custom')]
class MyCustomParser extends Parser
{
	public function parse(
		Fragment $fragment,
		Repository $repository
	): string
	{
		return 'My custom parser';
	}
}
```

The `DefaultParserName` is attribute optional, but recommended. It supplies the parser with a fallback/default name, in case the developer doesn't provide one.

You can familiarize yourself with `$fragment` and `$repository` in the chapter on parsing basics.

## Registration
### Single instance
You can register your parser on a single instance of `Text` with
```php
$text->use(MyCustomParser::class);
```

If you want to register under an alternate identifier, you can do:
```php
$text->use(MyCustomParser::class, 'alt');
```

### Globally
Or, you can register it globally to be used in all instances of `Text`.
```php
Text::global()->use(MyCustomParser::class);
```

## Usage
```php
$text = new Text('My parser says: custom:()');

var_dump($text->parse);  // My parser says: My custom parser
```