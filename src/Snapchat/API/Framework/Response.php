<?php


namespace Snapchat\API\Framework;

use Psr\Http\Message\ResponseInterface;

class Response
{
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;

    /**
     * @var ResponseInterface Guzzle response
     */
    private $response;

    /**
     * @var object Response Data;
     */
    private $data;

    /**
     * @param $response ResponseInterface
     * @param $data
     */
    public function __construct($response, $data)
    {
        $this->response = $response;
        $this->data = $data;
    }

    /**
     *
     * Get Response Code
     *
     * @return int Response Code
     */
    public function getCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     *
     * Get Response Data
     *
     * @return object Response Data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *
     * Get Response Headers
     *
     * @return array Response Data
     */
    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    public function getContentDispositionFilename()
    {
        $headers = $this->getHeaders();
        parse_str($headers["Content-Disposition"], $results);
        return $results["attachment;filename"];
    }

    /**
     *
     * Check if the Response was 200 OK
     *
     * @return bool
     */
    public function isOK()
    {
        return in_array($this->getCode(), array(self::OK, self::CREATED, self::ACCEPTED));
    }
}