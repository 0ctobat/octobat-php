<?php

namespace Octobat;

/**
 * Class BalanceTransaction
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property int $available_on
 * @property int $created
 * @property string $currency
 * @property string $description
 * @property float $exchange_rate
 * @property int $fee
 * @property mixed $fee_details
 * @property int $net
 * @property string $source
 * @property string $status
 * @property string $type
 *
 * @package Octobat
 */
class BalanceTransaction extends ApiResource
{
    use ApiOperations\Retrieve;
    use ApiOperations\All;

    public static function all($params = null, $opts = null)
    {
        self::_validateParams($params);
        $url = '/payouts/' . $params['payout'] . static::classUrl();

        list($response, $opts) = static::_staticRequest('get', $url, $params, $opts);
        $obj = \Octobat\Util\Util::convertToOctobatObject($response->json, $opts);
        if (!is_a($obj, 'Octobat\\Collection')) {
            $class = get_class($obj);
            $message = "Expected type \"Octobat\\Collection\", got \"$class\" instead";
            throw new Error\Api($message);
        }
        $obj->setLastResponse($response);
        $obj->setRequestParams($params);
        return $obj;
    }



    /**
     * @return string The instance URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public function instanceUrl()
    {
        if ($this['payout']) {
            $base = Payout::classUrl();
            $parent = $this['payout'];
            $path = 'balance_transactions';
        } else {
            $msg = "Balance transactions cannot be accessed without a Payout ID.";
            throw new Error\InvalidRequest($msg, null);
        }
        $parentExtn = urlencode(Util\Util::utf8($parent));
        $extn = urlencode(Util\Util::utf8($this['id']));
        return "$base/$parentExtn/$path/$extn";
    }
}
