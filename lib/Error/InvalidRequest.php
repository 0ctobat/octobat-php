<?php

namespace Octobat\Error;

class InvalidRequest extends Base
{
    public function __construct(
        $error,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null
    ) {

        $this->error = $error;
        parent::__construct($this->generate_message_from_error());
    }

    public function getError()
    {
        return $this->error;
    }


    private function generate_message_from_error()
    {
      if ($this->error === null) {
        return "";
      }

      $a = array();
      foreach ($this->error as $key => $value) {
        $msg = $key == "global" ? "" : $key . ": ";
        $msg.= $this->serialize_errors_from($value);
        $a[] = $msg;
      }

      return implode(". ", $a);
    }

    private function serialize_errors_from($errors)
    {
      $a = array();
      foreach ($errors as $err) {
        $a[] = $err["details"];
      }

      return implode(", ", $a);
    }
}
