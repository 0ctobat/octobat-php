<?php

namespace Octobat\Beanie;

/**
 * Class Session
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $mode
 * @property string $customer
 * @property string $success_url
 * @property string $cancel_url
 * @property Collection $display_items
 * @property string $save_payment_method
 * @property string $setup_future_usage
 * @property string $tax_calculation
 * @property string $billing_address_collection
 * @property bool $phone_number_collection
 * @property string $tax_number_validation
 * @property bool $coupon_collection
 * @property string $primary_color
 * @property string $locale
 * @property string $client_reference_id
 * @property OctobatObject $prefill_data
 * @property OctobatObject $metadata
 *
 * @package Octobat
 */
class Session extends \Octobat\ApiResource
{
    use \Octobat\ApiOperations\Create;
    use \Octobat\ApiOperations\Retrieve;

    /**
     * @return string The endpoint URL for the given class.
     */
    public static function classUrl()
    {
        $base = static::className();
        return "/beanie/${base}s";
    }


}
