<?php

namespace Octobat\ApiOperations;

/**
 * Trait for deletable resources. Adds a `delete()` method to the class.
 *
 * This trait should only be applied to classes that derive from OctobatObject.
 */
trait Delete
{
    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return \Octobat\ApiResource The deleted resource.
     */
    public function delete($params = null, $opts = null)
    {
        self::_validateParams($params);

        $url = $this->instanceUrl();
        list($response, $opts) = $this->_request('delete', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}
