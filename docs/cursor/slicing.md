# Slicing
```php
public function slice(): Cursor;
public function slices(): Collection;
```

Splitting texts can often be a bit complicated and messy. With the ````slice```` method you indicate positions where you want to split your string, and then you collect all the parts with ````slices````.

```php
$cursor = new Cursor('Hello world. How are you? Hopefully good.');

$cursor->set(12)->slice();
$cursor->set(25)->slice();

$cursor->slices();  // Returns 3 Text instances in a Collection containing "Hello world.", "How are you?" and "Hhopefully good."
```

## Notes
### End of the string
The end of the string is not ````length - 1```` because this would position the cursor before the final character. Therefore, the final cursor position equals the length of the string, i.e. on the right-hand side of the last character.
