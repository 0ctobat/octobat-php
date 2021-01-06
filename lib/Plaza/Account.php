<?php

namespace Octobat\Plaza;

/**
 * Class Account
 *
 * @property string $id
 * @property string $object
 * @property string $type
 * @property bool $livemode
 * @property string $country
 * @property string $email
 * @property \Octobat\OctobatObject[] $capabilities
 * @property bool $active
 * @property string $business_type
 * @property null|(\Octobat\OctobatObject) $company
 * @property null|(\Octobat\OctobatObject) $individual
 * @property \Octobat\OctobatObject $business_profile
 * @property \Octobat\OctobatObject $settings
 * @property \Octobat\OctobatObject $metadata
 * @property string $created_at
 * @property string $updated_at
 *
 * @package Octobat
 */
class Account extends \Octobat\ApiResource
{
    use \Octobat\ApiOperations\All;
    use \Octobat\ApiOperations\Create;
    use \Octobat\ApiOperations\Retrieve;
    use \Octobat\ApiOperations\Update;

    /**
     * @param array|string|null $params
     * @param array|string|null $opts
     *
     * @return Account The updated account.
     */

    public function deactivate($params = null, $options = null)
    {
        $url = $this->instanceUrl() . '/deactivate';
        list($response, $opts) = $this->_request('delete', $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }


    /**
     * @param array|string|null $params
     * @param array|string|null $opts
     *
     * @return Account The updated coupon.
     */

    public function activate($params = null, $options = null)
    {
        $url = $this->instanceUrl() . '/activate';
        list($response, $opts) = $this->_request('patch', $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array|null $params
     *
     * @return array An array of the account's Capabilities.
     */
    public function capabilities($params = null)
    {
        $params = $params ?: [];
        $params['account'] = $this->id;
        $items = Capability::all($params, $this->_opts);
        return $items;
    }


    /**
     * @return string The endpoint URL for the given class.
     */
    public static function classUrl()
    {
        $base = static::className();
        return "/plaza/${base}s";
    }


}
