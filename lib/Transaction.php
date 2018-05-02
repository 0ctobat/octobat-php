<?php

namespace Octobat;

/**
 * Class Transaction
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $customer
 * @property string $payment_source
 * @property string $payment_recipient
 * @property string $invoice
 * @property string $credit_note
 * @property int $amount
 * @property string $currency
 * @property string $status
 * @property string $transaction_date
 * @property string $flow_type
 * @property OctobatObject $sources
 *
 * @package Octobat
 */
class Transaction extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    /**
     * @param array|null $params
     *
     * @return array An array of the transaction's Items.
     */
    public function items($params = null)
    {
        $params = $params ?: [];
        $params['transaction'] = $this->id;
        $items = Item::all($params, $this->_opts);
        return $items;
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return true
     */
    public static function csv_export($params = null, $opts = null)
    {
        $url = static::classUrl() . '/csv_export';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        return true;
    }





}
