# Understanding the differences
The `Text` object offers three different types of iterators functioning ever so slightly from each other.

The `forEach` method will loop over the fragments, but you cannot modify them. This is meant purely as a convenient way to loop over the expressions and read relevant information about them.

The `map` will replace the expression and parse the output. This means that you have to use the `set` method to define an output for the `ExpressionFragment`. You can also return a `TextFragment` to replace it.

The `rebase` method works very similar to `map` but instead of replacing expressions with the output, it will replace with the `foundation` method of the fragment. For `TextFragment` this behaves the normal way, but for `ExpressionFragment` it will insert the signature of the expression, instead of the result/output. This allows you to replace expressions before they're parsed.

## See also
* [Fragments](/advanced/fragments)