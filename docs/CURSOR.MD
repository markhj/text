# Cursor
The ````Cursor```` object is used to conveniently read and extract from strings in a more structured and beautiful fashion.

The Cursor object is designed to operate completely without any independence on ````Text````.

To initialize a ``Cursor`` you simply construct the class with a required string argument.
```php
use Markhj\Text\Cursor;

$cursor = new Cursor('Here is some example text');
```

## Navigate
```php
public function position(): int;
public function toEnd(): Cursor;
public function set(int $position): Cursor;
public function rewind(): Cursor;
public function ended(): bool;
public function move(int|string|Text $size): Cursor;
```

### position
```php
public function position(): int
```
Retrieve the current cursor position. You can think of the cursor as the "blinking cursor" you see in text editing tools. The cursor is not on a character, but before it.

### toEnd
```php
public function toEnd(): Cursor
```
Move the cursor to the end of the text

### ended
```php
public function ended(): bool
```
Returns true if the cursor is at the end of the string.

### rewind
```php
public function rewind(): Cursor
```
Puts the cursor back to the beginning of the string (position 0)

### set
```php
public function set(int $position): Cursor
```
Set the cursor a specific position. The cursor will be forced to stay between 0 and the length of the string.

### move
```php
public function move(int|string|Text $size): Cursor
```
Move the cursor from its current position. If you pass a text, the cursor will be moved to the right corresponding to the length of the text.

If you specify a number the cursor will be moved that number of characters. A positive number moves the cursor to the right, a negative to the left.

## Selection

### selection
```php
public function selection(): ?string
```
When you move the cursor using ````set````, ````move````, ````rewind```` or ````toEnd```` the Cursor object will "select" the text between the last position of the cursor and the new position. You can grab this selection by calling ````selection````.

```php
$cursor = new Cursor('This is a line of text');

$cursor->set(4);
$cursor->selection(); // "This"

$cursor->move(3);
$cursor->selection(); // " is"
```

The ````selection```` method returns the selection packaged as a ````Text```` object.

### get
```php
public function get(): string
```
Retrieve the full text instance, including manipulations you may have carried out on it.

## Manipulation
### insert
```php
public function insert(string|Text $text): Cursor
```
Inserts the text at the cursor position, and moves the cursor to the end of the insertion.

```php
$cursor = new Cursor('This is a line of text');

$cursor->set(7)->insert('n\'t');
$cursor->text()->parse();	// This isn't a line of text
```

### delete
```php
public function delete(int $chars = 1): Cursor
```
Deletes on the right-hand side of the cursor, similar to pushing the DELETE button on your keyboard. The cursor position remains in the same place.

```php
$cursor = new Cursor('This that is a line of text');

$cursor->set(5)->delete(5); // Deletes "that "
$cursor->text()->parse();	// This is a line of text
```

### backspace
```php
public function backspace(int $chars = 1): Cursor
```
Deletes on the left-hand side of the cursor, similar to pushing the BACKSPACE button on your keyboard. The cursor is moved leftwards until the text is deleted.

```php
$cursor = new Cursor('This that is a line of text');

$cursor->set(9)->backspace(5); // Deletes "that "
$cursor->text()->parse();	// This is a line of text
```