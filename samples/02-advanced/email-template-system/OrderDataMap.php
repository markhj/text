<?php

use Markhj\Text\DataMap\DataMap;
use Markhj\Text\Attributes\DataMap\DataMapKey;

class OrderDataMap extends DataMap
{
	public function __construct(
		protected StdClass $order
	) {
		parent::__construct();
	}

	#[DataMapKey]
	public function total(): string
	{
		return number_format($this->order->totalAmount, 2);
	}
}
