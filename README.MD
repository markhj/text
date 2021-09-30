This library provides a number of handy classes to make string manipulation and analysis easier and more beautiful. Composer 2 is required to install, and the library requires PHP 8 or higher.

The library additionally requires mbstring extension.

# Install
## Composer 2
```
composer require markhj/text
```

# Usage
Please refer to the ````docs```` folder for more detailed documentation.

# Getting started

## Cursor
The ````Cursor```` library is technically a more primitive class which was introduced to ease the creation of the ````Text```` object, but it was decided to also make this class readily available. This object makes it an intuitive breeze to read, search and manipulate strings by numeric positions.

```php
$cursor = new Text(new Cursor('Hello world'));

// Adding to a string
$cursor->move(5)->insert('wonderful '); 	// Hello wonderful world

// Getting a part of the string
$cursor->toEnd()->move(-5)->selection(); 	// "world"
```
