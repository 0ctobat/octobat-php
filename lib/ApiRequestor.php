<?php

namespace Octobat;

/**
 * Class ApiRequestor
 *
 * @package Octobat
 */
class ApiRequestor
{
    private $_apiKey;

    private $_apiBase;

    private static $_httpClient;

    public function __construct($apiKey = null, $apiBase = null)
    {
        $this->_apiKey = $apiKey;
        if (!$apiBase) {
            $apiBase = Octobat::$apiBase;
        }
        $this->_apiBase = $apiBase;
    }

    private static function _encodeObjects($d)
    {
        if ($d instanceof ApiResource) {
            return Util\Util::utf8($d->id);
        } elseif ($d === true) {
            return 'true';
        } elseif ($d === false) {
            return 'false';
        } elseif (is_array($d)) {
            $res = [];
            foreach ($d as $k => $v) {
                $res[$k] = self::_encodeObjects($v);
            }
            return $res;
        } else {
            return Util\Util::utf8($d);
        }
    }

    /**
     * @param string $method
     * @param string $url
     * @param array|null $params
     * @param array|null $headers
     *
     * @return array An array whose first element is an API response and second
     *    element is the API key used to make the request.
     */
    public function request($method, $url, $params = null, $headers = null)
    {
        $params = $params ?: [];
        $headers = $headers ?: [];
        list($rbody, $rcode, $rheaders, $myApiKey) =
        $this->_requestRaw($method, $url, $params, $headers);
        $json = $this->_interpretResponse($rbody, $rcode, $rheaders);
        $resp = new ApiResponse($rbody, $rcode, $rheaders, $json);
        return [$resp, $myApiKey];
    }

    /**
     * @param string $rbody A JSON string.
     * @param int $rcode
     * @param array $rheaders
     * @param array $resp
     *
     * @throws Error\InvalidRequest if the error is caused by the user.
     * @throws Error\Idempotency if the error is caused by an idempotency key.
     * @throws Error\Authentication if the error is caused by a lack of
     *    permissions.
     * @throws Error\Permission if the error is caused by insufficient
     *    permissions.
     * @throws Error\Card if the error is the error code is 402 (payment
     *    required)
     * @throws Error\RateLimit if the error is caused by too many requests
     *    hitting the API.
     * @throws Error\Api otherwise.
     */
    public function handleErrorResponse($rbody, $rcode, $rheaders, $resp)
    {

        if (!is_array($resp) || (!isset($resp['error']) && !isset($resp['errors']))) {
            $msg = "Invalid response object from API: $rbody "
              . "(HTTP response code was $rcode)";
            throw new Error\Api($msg, $rcode, $rbody, $resp, $rheaders);
        }

        $errorData = isset($resp['error']) ? $resp['error'] : $resp['errors'];

        $error = null;
        /*
        if (is_string($errorData)) {
            $error = self::_specificOAuthError($rbody, $rcode, $rheaders, $resp, $errorData);
        }
        */
        if (!$error) {
            $error = self::_specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData);
        }

        throw $error;
    }

    private static function _specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData)
    {
        $msg = isset($errorData['message']) ? $errorData['message'] : null;
        $param = isset($errorData['param']) ? $errorData['param'] : null;
        $code = isset($errorData['code']) ? $errorData['code'] : null;
        $type = isset($errorData['type']) ? $errorData['type'] : null;

        switch ($rcode) {
            case 400:
                return new Error\InvalidRequest($errorData, $rcode, $rbody, $resp, $rheaders);
                // intentional fall-through
            case 404:
                return new Error\Api($msg, $param, $rcode, $rbody, $resp, $rheaders);
            case 401:
                return new Error\Authentication($msg, $rcode, $rbody, $resp, $rheaders);
            case 402:
                return new Error\Api($msg, $rcode, $rbody, $resp, $rheaders);
            case 422:
                return new Error\InvalidRequest($msg, $rcode, $rbody, $resp, $rheaders);
            case 409:
              return new Error\Idempotency($msg, $rcode, $rbody, $resp, $rheaders);
            case 403:
                return new Error\Permission($msg, $rcode, $rbody, $resp, $rheaders);
            case 429:
                return new Error\RateLimit($msg, $param, $rcode, $rbody, $resp, $rheaders);
            default:
                return new Error\Api($msg, $rcode, $rbody, $resp, $rheaders);
        }
    }


    private static function _formatAppInfo($appInfo)
    {
        if ($appInfo !== null) {
            $string = $appInfo['name'];
            if ($appInfo['version'] !== null) {
                $string .= '/' . $appInfo['version'];
            }
            if ($appInfo['url'] !== null) {
                $string .= ' (' . $appInfo['url'] . ')';
            }
            return $string;
        } else {
            return null;
        }
    }

    private static function _defaultHeaders($apiKey, $clientInfo = null)
    {
        $uaString = 'Octobat/v2 PhpBindings/' . Octobat::VERSION;

        $langVersion = phpversion();
        $uname = php_uname();

        $appInfo = Octobat::getAppInfo();
        $ua = [
            'bindings_version' => Octobat::VERSION,
            'lang' => 'php',
            'lang_version' => $langVersion,
            'publisher' => 'octobat',
            'uname' => $uname,
        ];
        if ($clientInfo) {
            $ua = array_merge($clientInfo, $ua);
        }
        if ($appInfo !== null) {
            $uaString .= ' ' . self::_formatAppInfo($appInfo);
            $ua['application'] = $appInfo;
        }

        $defaultHeaders = [
            'X-Octobat-Client-User-Agent' => json_encode($ua),
            'User-Agent' => $uaString,
            'Authorization' => 'Basic ' . base64_encode($apiKey.':'),
            //'Authorization' => 'Bearer ' . $apiKey,
        ];
        return $defaultHeaders;
    }

    private function _requestRaw($method, $url, $params, $headers)
    {
        $myApiKey = $this->_apiKey;
        if (!$myApiKey) {
            $myApiKey = Octobat::$apiKey;
        }

        if (!$myApiKey) {
            $msg = 'No API key provided.  (HINT: set your API key using '
              . '"Octobat::setApiKey(<API-KEY>)".';
            throw new Error\Authentication($msg);
        }

        // Clients can supply arbitrary additional keys to be included in the
        // X-Octobat-Client-User-Agent header via the optional getUserAgentInfo()
        // method
        $clientUAInfo = null;
        if (method_exists($this->httpClient(), 'getUserAgentInfo')) {
            $clientUAInfo = $this->httpClient()->getUserAgentInfo();
        }

        $absUrl = $this->_apiBase.$url;
        $params = self::_encodeObjects($params);
        $defaultHeaders = $this->_defaultHeaders($myApiKey, $clientUAInfo);
        if (Octobat::$apiVersion) {
            $defaultHeaders['Octobat-Version'] = Octobat::$apiVersion;
        }

        $hasFile = false;
        $hasCurlFile = class_exists('\CURLFile', false);
        foreach ($params as $k => $v) {
            if (is_resource($v)) {
                $hasFile = true;
                $params[$k] = self::_processResourceParam($v, $hasCurlFile);
            } elseif ($hasCurlFile && $v instanceof \CURLFile) {
                $hasFile = true;
            }
        }

        if ($hasFile) {
            $defaultHeaders['Content-Type'] = 'multipart/form-data';
        } else {
            $defaultHeaders['Content-Type'] = 'application/x-www-form-urlencoded';
        }
        
        $combinedHeaders = array_merge($defaultHeaders, $headers);
        $rawHeaders = [];

        foreach ($combinedHeaders as $header => $value) {
            $rawHeaders[] = $header . ': ' . $value;
        }
        

        list($rbody, $rcode, $rheaders) = $this->httpClient()->request(
            $method,
            $absUrl,
            $rawHeaders,
            $params,
            $hasFile
        );
        return [$rbody, $rcode, $rheaders, $myApiKey];
    }

    private function _processResourceParam($resource, $hasCurlFile)
    {
        if (get_resource_type($resource) !== 'stream') {
            throw new Error\Api(
                'Attempted to upload a resource that is not a stream'
            );
        }

        $metaData = stream_get_meta_data($resource);
        if ($metaData['wrapper_type'] !== 'plainfile') {
            throw new Error\Api(
                'Only plainfile resource streams are supported'
            );
        }

        if ($hasCurlFile) {
            // We don't have the filename or mimetype, but the API doesn't care
            return new \CURLFile($metaData['uri']);
        } else {
            return '@'.$metaData['uri'];
        }
    }

    private function _interpretResponse($rbody, $rcode, $rheaders)
    {
        $resp = json_decode($rbody, true);
        $jsonError = json_last_error();
        if ($resp === null && $jsonError !== JSON_ERROR_NONE) {
            $msg = "Invalid response body from API: $rbody "
              . "(HTTP response code was $rcode, json_last_error() was $jsonError)";
            throw new Error\Api($msg, $rcode, $rbody);
        }

        if ($rcode < 200 || $rcode >= 300) {
            $this->handleErrorResponse($rbody, $rcode, $rheaders, $resp);
        }
        return $resp;
    }

    public static function setHttpClient($client)
    {
        self::$_httpClient = $client;
    }

    private function httpClient()
    {
        if (!self::$_httpClient) {
            self::$_httpClient = HttpClient\CurlClient::instance();
        }
        return self::$_httpClient;
    }
}
