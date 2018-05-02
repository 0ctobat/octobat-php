<?php

namespace Octobat;

/**
 * Class PaymentRecipientReference
 *
 * @property string $id
 * @property string $object
 * @property string $code
 * @property OctobatObject $fields
 *
 * @package Octobat
 */
class PaymentRecipientReference extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Retrieve;
}
