<?php

namespace Octobat;

/**
 * Class ProformaInvoice
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $customer
 * @property string $invoice
 * @property string $document_template
 * @property string $pdf_file_url
 * @property string $proforma_invoice_number
 * @property string $proforma_invoice_date
 * @property string $description
 * @property int $total_extratax_amount
 * @property int $total_tax_amount
 * @property int $total_gross_amount
 * @property string $notes
 * @property string $language
 * @property string $customer_locale
 * @property string $currency
 * @property string $customer_name
 * @property string $customer_address_line_1
 * @property string $customer_address_line_2
 * @property string $customer_address_city
 * @property string $customer_address_state
 * @property string $customer_address_zip
 * @property string $customer_address_country
 * @property string $customer_country_code
 * @property string $customer_tax_number
 * @property string $customer_business_type
 * @property string $supplier_address_line_1
 * @property string $supplier_address_line_2
 * @property string $supplier_address_city
 * @property string $supplier_address_state
 * @property string $supplier_address_zip
 * @property string $supplier_address_country
 * @property string $supplier_tax_number
 * @property OctobatObject $legal_fields
 * @property OctobatObject $metadata
 * @property int $proforma_invoice_items_count
 * @property Collection $proforma_invoice_items
 *
 * @package Octobat
 */
class ProformaInvoice extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\NestedResource;

    public static function getSavedNestedResources()
    {
        static $savedNestedResources = null;
        if ($savedNestedResources === null) {
            $savedNestedResources = new Util\Set([
                'proforma_invoice_item',
            ]);
        }
        return $savedNestedResources;
    }

    const PATH_PROFORMA_INVOICE_ITEMS = '/proforma_invoice_items';

}
