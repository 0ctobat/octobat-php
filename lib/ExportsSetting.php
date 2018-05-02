<?php

namespace Octobat;

/**
 * Class ExportsSetting
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $recipient_email
 * @property bool $format_csv_for_excel_on_windows
 *
 * @package Octobat
 */

class ExportsSetting extends ApiResource
{
  use ApiOperations\Create;
  use ApiOperations\Update;

  /**
   * @param array|null $params
   * @param array|string|null $opts
   *
   * @return ExportsSetting The default ExportsSetting
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
