<?php

require __DIR__ . '/../../init.php';
require __DIR__ . '/EmailTemplate.php';
require __DIR__ . '/GlobalDataMap.php';
require __DIR__ . '/OrderDataMap.php';

use Markhj\Text\TextFromFile;
use Markhj\Text\Text;

title('Complex example: Creating a general email parser');

/**
 * Provide a data map you want to use everywhere
 *
 * This code should be placed at the initialization of your script/application
 */
Text::global()->repository()->provide(
    GlobalDataMap::class
);

/**
 * Use a data map to parse object types in certain ways
 */
$order = new StdClass;
$order->id = 625322;
$order->totalAmount = 299;

$orderMap = new OrderDataMap($order);

/**
 * Initialize the text
 */

// Put to file and show as templates
$text = new EmailTemplate(__DIR__ . '/email.html');


class EmailParserService
{
    public function parse(string $template)
    {
        
    }
}

// $text->repository()->provide($orderMap);

// EXAMPLIFY CUSTOMER LOCALE

text($text);
