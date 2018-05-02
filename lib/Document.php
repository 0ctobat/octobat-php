<?php

namespace Octobat;

/**
 * Class Document
 *
 * @package Octobat
 */

class Document extends ApiResource
{
  /**
   * @param array|null $params
   * @param array|string|null $opts
   *
   * @return true
   */
  public static function csv_export($params = null, $opts = null)
  {
      $url = static::classUrl() . '/csv_export';
      list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
      return true;
  }
}
