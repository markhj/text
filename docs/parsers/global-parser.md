# Global use of parser

You can register parsers globally for use in every instance of `Text`. You must perform these actions in the bootstrapping of your application.

## Use clause
If you want to register a parser class, you simply call the `TextGlobal::use` method.

```php
Text::global()->use(CustomParser::class);
```

You can invoke the parser under a different name, by adding the second argument:
```php
Text::global()->use(CustomParser::class, 'alt');
```

## Instruction
Similar to how you can do on single instances of `Text` you can also write global parsers like this:

```php
Text::global()->on('global')->do(function($fragment, $repository) {
	return 'Some global parsing';
});
```