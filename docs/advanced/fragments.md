# Fragments

When the parser breaks up the `Text` to find and handle expressions, all the pieces are known as **fragments**. A fragment can either be a `TextFragment` or an `ExpressionFragment`.

## *ExpressionFragment*
When you work with an `ExpressionFragment` it's important to understand its methods and their rather small, but important, discrepancies.

Let's imagine an expression `p:name()`. When you handle an `ExpressionFragment` this is its foundation (or signature). You retrieve the raw expression with `ExpressionFragment::foundation` method. With `ExpressionFragment::rebase` you can change the expression itself. If you're interested in a practical usecase you can explore the source code of `Text::transform` - which is also described further in [how to convert expression patterns](/expression-patterns/convertpattern/).

The probably more interesting part is `get` and `set` which works with its *output*. The result of the expression.

For example, if you want to perform an uppercase operation on all printed variables, you can do this:

```php
$text->on('p')->do(function($fragment) {
	return strtoupper($fragment->get());
});
```

## *TextFragment*
The `TextFragment` is built with the same logic at hand, but due to its nature there's no difference between working with output or foundation.