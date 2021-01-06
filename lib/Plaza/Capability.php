<?php

namespace Octobat\Plaza;

/**
 * Class Capability
 *
 * @property string $id
 * @property string $object
 * @property string $account
 * @property bool $livemode
 * @property bool $requested
 * @property string $requested_at
 * @property string $status
 * @property \Octobat\OctobatObject $requirements
 *
 * @package Octobat
 */
class Capability extends \Octobat\ApiResource
{
    use \Octobat\ApiOperations\All;
    use \Octobat\ApiOperations\Retrieve;

    /**
     * @return string The endpoint URL for the given class.
     */
    public static function classUrl()
    {
        return "/capabilities";
    }


    public static function all($params = null, $opts = null)
    {
        self::_validateParams($params);

        if ($params['account']) {
          $url = '/plaza/accounts/' . $params['account'] . static::classUrl();
        } else {
          $msg = "Capabilities cannot be accessed without an Account ID.";
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
        if ($this['account']) {
            $base = Account::classUrl();
            $parent = $this['account'];
            $path = 'capabilities';
        } else {
            $msg = "Capabilities cannot be accessed without an Account ID.";
            throw new Error\Api($msg, null);
        }
        $parentExtn = urlencode(Util\Util::utf8($parent));
        $extn = urlencode(Util\Util::utf8($this['id']));
        return "$base/$parentExtn/$path/$extn";
    }

    /**
     * @param array|string|null $options
     *
     * @return Capability The requested Capability.
     */
    public function ask($params = null, $options = null)
    {
        $url = $this->instanceUrl() . '/request';
        list($response, $opts) = $this->_request('patch', $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}
