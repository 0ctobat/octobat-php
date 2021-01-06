<?php

namespace Octobat\Plaza;

/**
 * Class CountrySpec
 *
 * @property string $id
 * @property string $object
 * @property string $country
 * @property \Octobat\OctobatObject $requirements
 *
 * @package Octobat
 */
class CountrySpec extends \Octobat\ApiResource
{
    use \Octobat\ApiOperations\All;
    use \Octobat\ApiOperations\Retrieve;

    /**
     * @return string The endpoint URL for the given class.
     */
    public static function classUrl()
    {
        $base = static::className();
        return "/plaza/${base}s";
    }

}
