<?php

namespace Octobat\Error;

use Exception;

abstract class Base extends Exception
{
    public function __construct(
        $message,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null
    ) {
        parent::__construct($message);
        $this->httpStatus = $httpStatus;
        $this->httpBody = $httpBody;
        $this->jsonBody = $jsonBody;
        $this->httpHeaders = $httpHeaders;
        $this->requestId = null;

        if ($httpHeaders && isset($httpHeaders['Request-Id'])) {
            $this->requestId = $httpHeaders['Request-Id'];
        }
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    public function getHttpBody()
    {
        return $this->httpBody;
    }

    public function getJsonBody()
    {
        return $this->jsonBody;
    }

    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }

    public function getRequestId()
    {
        return $this->requestId;
    }

    public function __toString()
    {
        $id = $this->requestId ? " from API request '{$this->requestId}'": "";
        $message = explode("\n", parent::__toString());
        $message[0] .= $id;
        return implode("\n", $message);
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
