<?php

namespace Octobat;

/**
 * Class TaxEvidence
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
class TaxEvidence extends ApiResource
{
    use ApiOperations\Create;


}
