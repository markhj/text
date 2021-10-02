# Text from file

The `TextFromFile` is an extension of `Text` designed to work with files. It provides all the known capabilities of `Text` with a few methods added.

## Initialize
When you initialize the object the first, and only, argument is the filename.

```php
$text = new TextFromFile('/path/to/file.html');
```

## Saving
You can either save to a new file or on top of the existing. Both are achieved using `save` method. If you don't provide an argument it will save to the same file, and otherwise it takes a string to the new file.

The method does **not** block overwrites.

### Save to same file
```php
$text = new TextFromFile('file.html');
// ...
$text->save();
```

### Save to new file
```php
$text = new TextFromFile('file.html');
// ...
$text->save('new.html');
```