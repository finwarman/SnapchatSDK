<?php


namespace Snapchat\API\Response;


class BaseResponse
{
    /** @var bool */
    private $logged;

    /** @var string */
    private $message;

    /**
     * @return bool
     */
    public function isLogged()
    {
        return $this->logged;
    }

    /**
     * @param bool $logged
     */
    public function setLogged($logged)
    {
        $this->logged = $logged;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}