<?php

require __DIR__ . '/../vendor/autoload.php';

function title($text)
{
	echo PHP_EOL;
	echo "\033[0;30;42m" . $text . "\033[0m";
	echo PHP_EOL;
}

function text($text)
{
	echo PHP_EOL;
	echo "\033[35mBefore\033[0m: ";
	echo $text->template();
	echo PHP_EOL;
	echo "\033[33mAfter\033[0m: ";
	echo $text;
	echo PHP_EOL;
}
