<?php

namespace Octobat;

/**
 * Class EmailsSetting
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property bool $blind_carbon_copy
 * @property string $blind_carbon_copy_email
 * @property string $documents_emails_from
 * @property string $spf
 * @property string $dkim
 * @property string $sender_domain
 *
 * @package Octobat
 */

class EmailsSetting extends ApiResource
{
  use ApiOperations\Create;
  use ApiOperations\Update;

  /**
   * @param array|null $params
   * @param array|string|null $opts
   *
   * @return EmailsSetting The default EmailsSetting
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
