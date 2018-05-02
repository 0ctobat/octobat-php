<?php

namespace Octobat;

/**
 * Class TaxEvidenceRequest
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $sale_mode
 * @property string $product_type
 * @property OctobatObject $supplier_evidence
 * @property OctobatObject $supplier_localization
 * @property OctobatObject $customer_evidence
 * @property OctobatObject $customer_localization
 * @property bool $tax_enabled
 * @property string $tax
 * @property string $tax_zone
 * @property string $declare_in_region
 * @property float $applied_rate
 * @property OctobatObject $tax_details
 * @property OctobatObject $tax_id_validation
 *
 * @package Octobat
 */
class TaxEvidenceRequest extends ApiResource
{
    use ApiOperations\Create;

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return true
     */
    public static function for_supplier($params = null, $opts = null)
    {
        self::_validateParams($params);
        $url = static::classUrl() . '/for_supplier';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);

        $obj = \Octobat\Util\Util::convertToOctobatObject($response->json, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }
}
