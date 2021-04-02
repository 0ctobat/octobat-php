<?php

namespace Octobat\Util;

use Octobat\OctobatObject;

abstract class Util
{
    private static $isMbstringAvailable = null;
    private static $isHashEqualsAvailable = null;

    /**
     * Whether the provided array (or other) is a list rather than a dictionary.
     * A list is defined as an array for which all the keys are consecutive
     * integers starting at 0. Empty arrays are considered to be lists.
     *
     * @param array|mixed $array
     * @return boolean true if the given object is a list.
     */
    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }
        if ($array === []) {
            return true;
        }
        if (array_keys($array) !== range(0, count($array) - 1)) {
            return false;
        }
        return true;
    }

    /**
     * Recursively converts the PHP Octobat object to an array.
     *
     * @param array $values The PHP Octobat object to convert.
     * @return array
     */
    public static function convertOctobatObjectToArray($values)
    {
        $results = [];
        foreach ($values as $k => $v) {
            // FIXME: this is an encapsulation violation
            if ($k[0] == '_') {
                continue;
            }
            if ($v instanceof OctobatObject) {
                $results[$k] = $v->__toArray(true);
            } elseif (is_array($v)) {
                $results[$k] = self::convertOctobatObjectToArray($v);
            } else {
                $results[$k] = $v;
            }
        }
        return $results;
    }

    /**
     * Converts a response from the Octobat API to the corresponding PHP object.
     *
     * @param array $resp The response from the Octobat API.
     * @param array $opts
     * @return OctobatObject|array
     */
    public static function convertToOctobatObject($resp, $opts)
    {
        $types = [
          // data structures
          'list' => 'Octobat\\Collection',

          'balance_transaction' => 'Octobat\\BalanceTransaction',
          'checkout' => 'Octobat\\Checkout',
          'coupon' => 'Octobat\\Coupon',
          'credit_note' => 'Octobat\\CreditNote',
          'credit_note_numbering_sequence' => 'Octobat\\CreditNoteNumberingSequence',
          'customer' => 'Octobat\\Customer',
          'document' => 'Octobat\\Document',
          'document_email_template' => 'Octobat\\DocumentEmailTemplate',
          'document_language' => 'Octobat\\DocumentLanguage',
          'document_template' => 'Octobat\\DocumentTemplate',
          'emails_setting' => 'Octobat\\EmailsSetting',
          'exports_setting' => 'Octobat\\ExportsSetting',
          'invoice' => 'Octobat\\Invoice',
          'invoice_numbering_sequence' => 'Octobat\\InvoiceNumberingSequence',
          'item' => 'Octobat\\Item',
          'order' => 'Octobat\\Order',
          'payment_recipient' => 'Octobat\\PaymentRecipient',
          'payment_recipient_reference' => 'Octobat\\PaymentRecipientReference',
          'payment_source' => 'Octobat\\PaymentSource',
          'payout' => 'Octobat\\Payout',
          'proforma_invoice' => 'Octobat\\ProformaInvoice',
          'proforma_invoice_item' => 'Octobat\\ProformaInvoiceItem',
          'tax_evidence' => 'Octobat\\TaxEvidence',
          'tax_evidence_request' => 'Octobat\\TaxEvidenceRequest',
          'tax_region_setting' => 'Octobat\\TaxRegionSetting',
          'transaction' => 'Octobat\\Transaction',

          'plaza.account' => 'Octobat\\Plaza\\Account',
          'plaza.capability' => 'Octobat\\Plaza\\Capability',
          'plaza.country_spec' => 'Octobat\\Plaza\\CountrySpec',

          'beanie.session' => 'Octobat\\Beanie\\Session',
        ];
        if (self::isList($resp)) {
            $mapped = [];
            foreach ($resp as $i) {
                array_push($mapped, self::convertToOctobatObject($i, $opts));
            }
            return $mapped;
        } elseif (is_array($resp)) {
            if (isset($resp['object']) && is_string($resp['object']) && isset($types[$resp['object']])) {
                $class = $types[$resp['object']];
            } else {
                $class = 'Octobat\\OctobatObject';
            }
            return $class::constructFrom($resp, $opts);
        } else {
            return $resp;
        }
    }

    /**
     * @param string|mixed $value A string to UTF8-encode.
     *
     * @return string|mixed The UTF8-encoded string, or the object passed in if
     *    it wasn't a string.
     */
    public static function utf8($value)
    {
        if (self::$isMbstringAvailable === null) {
            self::$isMbstringAvailable = function_exists('mb_detect_encoding');

            if (!self::$isMbstringAvailable) {
                trigger_error("It looks like the mbstring extension is not enabled. " .
                    "UTF-8 strings will not properly be encoded. Ask your system " .
                    "administrator to enable the mbstring extension, or write to " .
                    "tech@octobat.com if you have any questions.", E_USER_WARNING);
            }
        }

        if (is_string($value) && self::$isMbstringAvailable && mb_detect_encoding($value, "UTF-8", true) != "UTF-8") {
            return utf8_encode($value);
        } else {
            return $value;
        }
    }

    /**
     * Compares two strings for equality. The time taken is independent of the
     * number of characters that match.
     *
     * @param string $a one of the strings to compare.
     * @param string $b the other string to compare.
     * @return bool true if the strings are equal, false otherwise.
     */
    public static function secureCompare($a, $b)
    {
        if (self::$isHashEqualsAvailable === null) {
            self::$isHashEqualsAvailable = function_exists('hash_equals');
        }

        if (self::$isHashEqualsAvailable) {
            return hash_equals($a, $b);
        } else {
            if (strlen($a) != strlen($b)) {
                return false;
            }

            $result = 0;
            for ($i = 0; $i < strlen($a); $i++) {
                $result |= ord($a[$i]) ^ ord($b[$i]);
            }
            return ($result == 0);
        }
    }

    /**
     * @param array $arr A map of param keys to values.
     * @param string|null $prefix
     *
     * @return string A querystring, essentially.
     */
    public static function urlEncode($arr, $prefix = null)
    {
        if (!is_array($arr)) {
            return $arr;
        }

        $r = [];
        foreach ($arr as $k => $v) {
            if (is_null($v)) {
                continue;
            }

            if ($prefix) {
                if ($k !== null && (!is_int($k) || is_array($v))) {
                    $k = $prefix."[".$k."]";
                } else {
                    $k = $prefix."[]";
                }
            }

            if (is_array($v)) {
                $enc = self::urlEncode($v, $k);
                if ($enc) {
                    $r[] = $enc;
                }
            } else {
                $r[] = urlencode($k)."=".urlencode($v);
            }
        }

        return implode("&", $r);
    }

    public static function normalizeId($id)
    {
        if (is_array($id)) {
            $params = $id;
            $id = $params['id'];
            unset($params['id']);
        } else {
            $params = [];
        }
        return [$id, $params];
    }
}
