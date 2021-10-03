<?php

require __DIR__ . '/../init.php';

use Markhj\Text\Text;
use Markhj\Text\DataMap\EmptyDataMap;

/**
 * Custom string manipulation
 */

title('Basic string manipulation');

$text = new Text('Hello w:()!');

// Note how the same expression can be operated on multiple times,
// but also with multiple instructions

$text
	->on('w')->do(function($fragment) {
		return 'world';
	})
	->on('w')->do(function($fragment) {
		return strtoupper($fragment->get());
	});

text($text);

/**
 * Numbers
 */

title('Playing with numbers');

$text = new Text('Some numbers would be multiply:(5,2), multiply:(7,4) and finally add:(10,5). A random number would be rand:()!');

$text->on('multiply')->do(function($fragment) {
	$args = $fragment->arguments();

	return $args->get(0) * $args->get(1);
});

$text->on('add')->do(function($fragment) {
	$args = $fragment->arguments();

	return $args->get(0) + $args->get(1);
});

$text->on('rand')->do(function() {
	return rand(1, 100);
});

text($text);

/**
 * Example with emails
 */

title('Another example');

$text = new Text('Their email is email:(name@example.com) or email:(not-an-email)');

$text->on('email')->do(function($fragment) {
	$email = $fragment->arguments()->get(0);

	return filter_var($email, FILTER_VALIDATE_EMAIL)
		? $email
		: '**INVALID EMAIL**';
});

text($text);
