<?php

namespace Octobat;


/**
 * Class Item
 *
 * @property string $id
 * @property string $object
 * @property string $status
 * @property string $currency
 * @property string $confirmed_on
 * @property string $customer
 * @property string $transaction
 * @property string $invoice
 * @property string $credit_note
 * @property string $product_type
 * @property string $sale_mode
 * @property bool $discountable
 * @property string $description
 * @property int $quantity
 * @property int $unit_extratax_amount
 * @property int $extratax_amount
 * @property int $tax_amount
 * @property int $gross_amount
 * @property float $tax_rate
 * @property string $tax
 * @property string $declare_in_region
 * @property OctobatObject $tax_evidence
 * @property OctobatObject $sources
 * @property OctobatObject $item_exchange
 * @property OctobatObject $item_workspace_currency_exchange
 *
 * @package Octobat
 */
class Item extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    public static function all($params = null, $opts = null)
    {
        self::_validateParams($params);

        if ($params['invoice']) {
          $url = '/invoices/' . $params['invoice'] . static::classUrl();
        } elseif ($params['credit_note']) {
          $url = '/credit_notes/' . $params['credit_note'] . static::classUrl();
        } elseif ($params['transaction']) {
          $url = '/transactions/' . $params['transaction'] . static::classUrl();
        } else {
          $msg = "Items cannot be accessed without a CreditNote, Invoice or Transaction ID.";
          throw new Error\Api($msg, null);
        }



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
        if ($this['invoice']) {
            $base = Invoice::classUrl();
            $parent = $this['invoice'];
            $path = 'items';
        } elseif ($this['credit_note']) {
          $base = CreditNote::classUrl();
          $parent = $this['credit_note'];
          $path = 'items';
        } elseif ($this['transaction']) {
          $base = Transaction::classUrl();
          $parent = $this['transaction'];
          $path = 'items';
        } else {
            $msg = "Items cannot be accessed without a CreditNote, Invoice or Transaction ID.";
            throw new Error\Api($msg, null);
        }
        $parentExtn = urlencode(Util\Util::utf8($parent));
        $extn = urlencode(Util\Util::utf8($this['id']));
        return "$base/$parentExtn/$path/$extn";
    }

}
