<?php

require __DIR__ . '/../../init.php';
require __DIR__ . '/EmailTemplate.php';
require __DIR__ . '/GlobalDataMap.php';
require __DIR__ . '/OrderDataMap.php';

use Markhj\Text\TextFromFile;

title('Advanced example: Creating a general email parser');

/**
 * Provide a data map you want to use everywhere
 *
 * This code should be placed at the initialization of your script/application
 */
TextFromFile::global()->repository()->provide(
    GlobalDataMap::class
);

/**
 * Use a data map to parse object types in certain ways
 */
$order = new StdClass;
$order->id = 625322;
$order->totalAmount = 299;
$order->locale = 'da_DK';

$orderMap = new OrderDataMap($order);

/**
 * Initialize the text
 */
$template = new EmailTemplate(__DIR__ . '/new_order.html');

$template->repository()->in('order')->provide($orderMap);
$template->repository()->root()->set('customer.name', 'John Doe');

text($template);
