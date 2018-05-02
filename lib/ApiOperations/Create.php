<?php

namespace Octobat\ApiOperations;

/**
 * Trait for creatable resources. Adds a `create()` static method to the class.
 *
 * This trait should only be applied to classes that derive from OctobatObject.
 */
trait Create
{
    /**
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return \Octobat\ApiResource The created resource.
     */
    public static function create($params = null, $options = null)
    {
        self::_validateParams($params);
        $url = static::classUrl();

        list($response, $opts) = static::_staticRequest('post', $url, $params, $options);
        $obj = \Octobat\Util\Util::convertToOctobatObject($response->json, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }
}
