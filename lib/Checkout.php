<?php

namespace Octobat;

/**
 * Class Checkout
 *
 * @property string $id
 * @property string $object
 * @property boolean $livemode
 * @property string $title
 * @property OctobatObject $css_attributes
 * @property boolean $button_style
 *
 * @package Octobat
 */
class Checkout extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

}
