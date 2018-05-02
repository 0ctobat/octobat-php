<?php

namespace Octobat;

/**
 * Class DocumentTemplate
 *
 * @property string $id
 * @property string $object
 * @property boolean $livemode
 * @property string $title
 * @property string $body
 * @property string $style
 * @property string $footer
 * @property string $status
 * @property string $created_at
 *
 * @package Octobat
 */
class DocumentTemplate extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    /**
     * @param array|string|null $options
     *
     * @return DocumentTemplate The new DocumentTemplate.
     */
    public function duplicate($params = null, $options = null)
    {
        $url = $this->instanceUrl() . '/duplicate';
        list($response, $opts) = $this->_request('post', $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array|string|null $options
     *
     * @return DocumentTemplate The activated DocumentTemplate.
     */
    public function activate($options = null)
    {
        $url = $this->instanceUrl() . '/activate';
        list($response, $opts) = $this->_request('patch', $url, null, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array|string|null $options
     *
     * @return DocumentTemplate The DocumentTemplate.
     */
    public function preview($options = null)
    {
        $url = $this->instanceUrl() . '/preview';
        list($response, $opts) = $this->_request('get', $url, null, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }

}
