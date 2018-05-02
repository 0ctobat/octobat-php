<?php

namespace Octobat;

/**
 * Class DocumentLanguage
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $fallback_language
 * @property bool $use_fallback_language
 * @property OctobatObject $contents
 *
 * @package Octobat
 */

class DocumentLanguage extends ApiResource
{
  use ApiOperations\Create;
  use ApiOperations\Update;

  /**
   * @param array|null $params
   * @param array|string|null $opts
   *
   * @return DocumentLanguage The default DocumentLanguage
   */
  public static function lookup_default($params = null, $opts = null)
  {
      $url = static::classUrl() . '/default';

      list($response, $opts) = static::_staticRequest('get', $url, $params, $opts);
      $obj = \Octobat\Util\Util::convertToOctobatObject($response->json, $opts);
      $obj->setLastResponse($response);
      return $obj;
  }

}
