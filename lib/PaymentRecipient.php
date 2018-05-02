<?php

namespace Octobat;
/**
 * Class PaymentRecipient
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property string $name
 * @property OctobatObject $details
 * @property OctobatObject $payment_recipient_reference
 *
 * @package Octobat
 */
class PaymentRecipient extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
}
