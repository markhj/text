# Navigating with cursor

Navigating with the cursor is essential to making `Cursor` useful.

## Methods
### position
```php
public function position(): int
```
Retrieve the current cursor position. You can think of the cursor as the "blinking cursor" you see in text editing tools. The cursor is not on a character, but before it.

### toNext
```php
public function toNext(string $char): Cursor
```
Move cursor to the left side of the next `$char`. For example, you can move to the next space with:

```php
$cursor->toNext(' ');
```


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

## Example
```php
$cursor = new Cursor('Here is some text');

$cursor->set(4); 	// Cursor is now on the right side of "Here"
```