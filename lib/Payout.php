<?php

namespace Octobat;

/**
 * Class Payout
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $status
 * @property string $payout_date
 * @property int $amount
 * @property string $currency
 * @property OctobatObject $bank_account_data
 * @property OctobatObject $sources
 *
 * @package Octobat
 */

class Payout extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Retrieve;

    /**
     * @param array|null $params
     *
     * @return array An array of the payout's BalanceTransactions.
     */
    public function balance_transactions($params = null)
    {
        $params = $params ?: [];
        $params['payout'] = $this->id;
        $balance_transactions = BalanceTransaction::all($params, $this->_opts);
        return $balance_transactions;
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
