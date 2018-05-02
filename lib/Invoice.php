<?php

namespace Octobat;


/**
 * Class Invoice
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $customer
 * @property string $invoice_numbering_sequence
 * @property string $document_template
 * @property Collection $payment_recipients
 * @property string $pdf_file_url
 * @property string $invoice_number
 * @property string $invoice_date
 * @property string $description
 * @property bool $email_sent
 * @property string $last_sent_at
 * @property string $status
 * @property string $payment_status
 * @property int $total_extratax_amount
 * @property int $total_tax_amount
 * @property int $total_gross_amount
 * @property int $paid_amount_cents
 * @property int $unpaid_amount_cents
 * @property string $notes
 * @property string $language
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
 * @property string $cancel_and_replace_invoice
 * @property string $replaced_by
 * @property OctobatObject $legal_fields
 * @property OctobatObject $sources
 * @property int $items_count
 * @property Collection $items
 *
 * @package Octobat
 */
class Invoice extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

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


    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return true
     */
    public static function pdf_export($params = null, $opts = null)
    {
        $url = static::classUrl() . '/pdf_export';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        return true;
    }



    /**
     * @param array|string|null $options
     *
     * @return Invoice The confirmed Invoice.
     */
    public function confirm($options = null)
    {
        $url = $this->instanceUrl() . '/confirm';
        list($response, $opts) = $this->_request('patch', $url, null, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }


    /**
     * @param array|string|null $options
     *
     * @return Invoice The cancelled Invoice.
     */
    public function cancel($options = null)
    {
        $url = $this->instanceUrl() . '/cancel';
        list($response, $opts) = $this->_request('patch', $url, null, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }


    /**
     * @param array|string|null $options
     *
     * @return Invoice The cancelled Invoice.
     */
    public function cancel_and_replace($options = null)
    {
        $url = $this->instanceUrl() . '/cancel_and_replace';
        list($response, $opts) = $this->_request('patch', $url, null, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }






    /**
     * @param array|string|null $options
     *
     * @return Invoice The sent invoice.
     */
    public function send_by_email($options = null)
    {
        $url = $this->instanceUrl() . '/send';
        list($response, $opts) = $this->_request('post', $url, null, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array|null $params
     *
     * @return array An array of the invoice's Items.
     */
    public function items($params = null)
    {
        $params = $params ?: [];
        $params['invoice'] = $this->id;
        $items = Item::all($params, $this->_opts);
        return $items;
    }

    /**
     * @param array|null $params
     *
     * @return array An array of the invoice's Transactions.
     */
    public function transactions($params = null)
    {
        $params = $params ?: [];
        $params['invoice'] = $this->id;
        $transactions = Transaction::all($params, $this->_opts);
        return $transactions;
    }
}
