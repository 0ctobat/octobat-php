<?php

namespace Octobat;

/**
 * Class PaymentSource
 *
 * @property string $id
 * @property string $object
 * @property string $customer
 * @property string $payment_source_type
 * @property OctobatObject $details
 * @property string $country
 * @property string $exp_month
 * @property string $exp_year
 * @property OctobatObject $sources
 * @property OctobatObject $evidence
 *
 * @package Octobat
 */
class PaymentSource extends ApiResource
{
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    /**
     * @return string The instance URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public function instanceUrl()
    {
        if ($this['customer']) {
            $base = Customer::classUrl();
            $parent = $this['customer'];
            $path = 'payment_sources';
        } else {
            $msg = "Payment sources cannot be accessed without a customer ID.";
            throw new Error\InvalidRequest($msg, null);
        }
        $parentExtn = urlencode(Util\Util::utf8($parent));
        $extn = urlencode(Util\Util::utf8($this['id']));
        return "$base/$parentExtn/$path/$extn";
    }

}
