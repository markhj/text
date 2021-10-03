# Selection

## selection
```php
public function selection(): ?string
```
When you move the cursor using ````set````, ````move````, ````rewind````, `toNext` or ````toEnd```` the Cursor object will "select" the text between the last position of the cursor and the new position. You can grab this selection by calling ````selection````.

```php
$cursor = new Cursor('This is a line of text');

$cursor->set(4);
$cursor->selection(); // "This"

$cursor->move(3);
$cursor->selection(); // " is"
```

The ````selection```` method returns the selection packaged as a ````Text```` object.

## get
```php
public function get(): string
```
Retrieve the full text instance, including manipulations you may have carried out on it.

