<?php

require __DIR__ . '/../../init.php';
require __DIR__ . '/EmailTemplate.php';
require __DIR__ . '/GlobalDataMap.php';

use Markhj\Text\TextFromFile;
use Markhj\Text\Text;

title('Complex example: Creating a general email parser');

Text::global()->use(
	GlobalDataMap::class
);

$text = new EmailTemplate(__DIR__ . '/email.html');

text($text);
