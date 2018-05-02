<?php

namespace Octobat;

/**
 * Class CreditNoteNumberingSequence
 *
 * @property string $id
 * @property string $object
 * @property string $prefix
 * @property bool $is_default
 * @property string $next_number
 * @property string $reset_to_zero
 *
 * @package Octobat
 */

class CreditNoteNumberingSequence extends ApiResource
{
  use ApiOperations\All;
  use ApiOperations\Create;
  use ApiOperations\Retrieve;
  use ApiOperations\Update;

  /**
   * @param array|string|null $options
   *
   * @return CreditNoteNumberingSequence The new default credit note numbering sequence.
   */
  public function set_to_default($options = null)
  {
      $url = $this->instanceUrl() . '/set_to_default_url';
      list($response, $opts) = $this->_request('patch', $url, null, $options);
      $this->refreshFrom($response, $opts);
      return $this;
  }

}
