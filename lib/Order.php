<?php

namespace Octobat;

/**
 * Class Order
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $client_secret
 * @property string $customer
 * @property string $credit_note
 * @property string $currency
 * @property string $status
 * @property string $billing_model
 * @property string $billing_interval
 * @property int $billing_interval_count
 * @property string $discount
 * @property string $tax_calculation
 * @property string $transaction_date
 * @oroperty string[] $payment_method_types
 * @property array $subscription_data
 * @property string $flow_type
 * @property string $created_at
 * @property string $updated_at
 * @property \Octobat\Beanie\Session $beanie_session
 * @property Collection $order_items
 * @property OctobatObject $metadata
 *
 * @package Octobat
 */
class Order extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

}
