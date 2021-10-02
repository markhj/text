<?php

use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;

class OrderDataMap extends DataMap
{
	public function __construct(
		protected StdClass $order
	) { }

	#[DataMapKey('currency')]
	public function total(): string
	{
		return $this->order->totalAmount;
	}
}
