<?php

namespace Octobat;

/**
 * Class TaxRegionSetting
 *
 * @property string $id
 * @property bool $livemode
 * @property bool $activated
 * @property int $amount_off
 * @property string $tax_zone_code
 * @property OctobatObject $regions
 *
 * @package Octobat
 */

class TaxRegionSetting extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    /**
     * @param array|string|null $params
     * @param array|string|null $opts
     *
     * @return TaxRegionSetting The updated tax region settings.
     */

    public function unactivate($params = null, $options = null)
    {
        $url = $this->instanceUrl() . '/unactivate';
        list($response, $opts) = $this->_request('patch', $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }


    /**
     * @param array|string|null $params
     * @param array|string|null $opts
     *
     * @return TaxRegionSetting The updated tax region settings.
     */

    public function activate($params = null, $options = null)
    {
        $url = $this->instanceUrl() . '/activate';
        list($response, $opts) = $this->_request('patch', $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }

}
