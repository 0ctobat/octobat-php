<?php

namespace Octobat;

/**
 * Class Coupon
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property bool $activated
 * @property int $amount_off
 * @property string $code
 * @property string $currency
 * @property int $max_redemptions
 * @property int $percent_off
 * @property int $times_redeemed
 *
 * @package Octobat
 */
class Coupon extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    /**
     * @param array|string|null $params
     * @param array|string|null $opts
     *
     * @return Coupon The updated coupon.
     */

    public function unactivate($params = null, $options = null)
    {
        $url = $this->instanceUrl() . '/unactivate';
        list($response, $opts) = $this->_request('patch', $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }


    /**
     * @param array|string|null $params
     * @param array|string|null $opts
     *
     * @return Coupon The updated coupon.
     */

    public function activate($params = null, $options = null)
    {
        $url = $this->instanceUrl() . '/activate';
        list($response, $opts) = $this->_request('patch', $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }

}
