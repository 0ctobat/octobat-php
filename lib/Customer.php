<?php

namespace Octobat;

/**
 * Class Customer
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $name
 * @property string $billing_address_line1
 * @property string $billing_address_line2
 * @property string $billing_address_city
 * @property string $billing_address_zip
 * @property string $billing_address_state
 * @property string $billing_address_country
 * @property string $business_type
 * @property string $tax_number
 * @property string $phone_number
 * @property string $website
 * @property string $octobat_billing_page
 * @property string $email
 * @property OctobatObject $metadata
 * @property OctobatObject $sources
 * @property Collection $payment_sources

 *
 * @package Octobat
 */
class Customer extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\NestedResource;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    public static function getSavedNestedResources()
    {
        static $savedNestedResources = null;
        if ($savedNestedResources === null) {
            $savedNestedResources = new Util\Set([
                'payment_source',
            ]);
        }
        return $savedNestedResources;
    }

    const PATH_PAYMENT_SOURCES = '/payment_sources';


    /**
     * @param array|null $params
     *
     * @return array An array of the customer's Invoices.
     */

    /*public function invoices($params = null)
    {
        $params = $params ?: [];
        $params['customer'] = $this->id;
        $invoices = Invoice::all($params, $this->_opts);
        return $invoices;
    }*/

    /**
     * @param array|null $id The ID of the customer on which to create the payment source.
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return ApiResource
     */
    public static function createPaymentSource($id, $params = null, $opts = null)
    {
        return self::_createNestedResource($id, static::PATH_PAYMENT_SOURCES, $params, $opts);
    }

    /**
     * @param array|null $id The ID of the customer to which the payment source belongs.
     * @param array|null $paymentSourceId The ID of the payment source to update.
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return ApiResource
     */
    public static function updatePaymentSource($id, $paymentSourceId, $params = null, $opts = null)
    {
        return self::_updateNestedResource($id, static::PATH_PAYMENT_SOURCES, $paymentSourceId, $params, $opts);
    }


    /**
     * @param array|null $id The ID of the customer to which the payment source belongs.
     * @param array|null $paymentSourceId The ID of the payment source to retrieve.
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return ApiResource
     */
    public static function retrievePaymentSource($id, $paymentSourceId, $params = null, $opts = null)
    {
        return self::_retrieveNestedResource($id, static::PATH_PAYMENT_SOURCES, $paymentSourceId, $params, $opts);
    }


    /**
     * @param array|null $id The ID of the customer on which to retrieve the payment sources.
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return ApiResource
     */
    public static function allPaymentSources($id, $params = null, $opts = null)
    {
        return self::_allNestedResources($id, static::PATH_PAYMENT_SOURCES, $params, $opts);
    }
}
