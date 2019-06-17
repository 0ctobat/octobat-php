<?php

namespace Octobat;


/**
 * Class CreditNote
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $customer
 * @property string $credit_note_numbering_sequence
 * @property string $document_template
 * @property string $invoice
 * @property string $pdf_file_url
 * @property string $credit_note_number
 * @property string $credit_note_date
 * @property string $invoice_number
 * @property string $description
 * @property bool $email_sent
 * @property string $last_sent_at
 * @property string $status
 * @property string $payment_status
 * @property int $total_extratax_amount
 * @property int $total_tax_amount
 * @property int $total_gross_amount
 * @property int $refunded_amount_cents
 * @property int $unrefunded_amount_cents
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
 * @property OctobatObject $sources
 * @property Collection $items
 *
 * @package Octobat
 */
class CreditNote extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    /**
     * @param array|string|null $options
     *
     * @return CreditNote The confirmed credit note.
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
     * @return CreditNote The sent credit note.
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
     * @return array An array of the credit note's Items.
     */
    public function items($params = null)
    {
        $params = $params ?: [];
        $params['credit_note'] = $this->id;
        $items = Item::all($params, $this->_opts);
        return $items;
    }

    /**
     * @param array|null $params
     *
     * @return array An array of the credit note's Transactions.
     */
    public function transactions($params = null)
    {
        $params = $params ?: [];
        $params['credit_note'] = $this->id;
        $transactions = Transaction::all($params, $this->_opts);
        return $transactions;
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
        return $response;
    }



}
