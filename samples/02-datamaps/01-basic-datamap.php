<?php

require __DIR__ . '/../init.php';

title('02 Data maps - 01 Basic datamap');

use Markhj\Text\Text;
use Markhj\Text\DataMap\EmptyDataMap;

$text = new Text('Hello #p[name]!');
$map = (new EmptyDataMap)->set('name', 'John Doe');

$text->repository()->provide($map);

text($text);
