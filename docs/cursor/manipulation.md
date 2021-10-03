# Manipulation
## insert
```php
public function insert(string|Text $text): Cursor
```
Inserts the text at the cursor position, and moves the cursor to the end of the insertion.

```php
$cursor = new Cursor('This is a line of text');

$cursor->set(7)->insert('n\'t');
$cursor->text()->parse();	// This isn't a line of text
```

## delete
```php
public function delete(int $chars = 1): Cursor
```
Deletes on the right-hand side of the cursor, similar to pushing the DELETE button on your keyboard. The cursor position remains in the same place.

```php
$cursor = new Cursor('This that is a line of text');

$cursor->set(5)->delete(5); // Deletes "that "
$cursor->text()->parse();	// This is a line of text
```

## backspace
```php
public function backspace(int $chars = 1): Cursor
```
Deletes on the left-hand side of the cursor, similar to pushing the BACKSPACE button on your keyboard. The cursor is moved leftwards until the text is deleted.

```php
$cursor = new Cursor('This that is a line of text');

$cursor->set(9)->backspace(5); // Deletes "that "
$cursor->text()->parse();	// This is a line of text
```