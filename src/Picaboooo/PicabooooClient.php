<?php


namespace Picaboooo;


use GuzzleHttp\Client;
use Snapchat\SnapchatClient;

class PicabooooClient
{
    const BASE_URL = 'https://picaboooo.com/v1/';
    const API_KEY = 'dac6d9c3-0628-455b-abb9-94cc2055f751';

    private $ts;
    private $seq;
    private $snapchat;
    private $client;

    /**
     * @param $snapchat SnapchatClient
     */
    public function __construct($snapchat)
    {
        $this->ts = round(microtime(true) * 1000);
        $this->seq = 0;
        $this->snapchat = $snapchat;
        $this->client = new Client([
            'base_uri' => self::BASE_URL,
            'headers' => [
                'X-API-Key' => self::API_KEY
            ]
        ]);
    }

    /**
     * @param $username
     * @param $authToken
     * @param $endpoint
     * @return mixed
     * @throws PicabooooException
     */
    public function getAuthenticatedEndpoint($username, $authToken, $endpoint)
    {
        $seq = $this->seq;

        if ($endpoint == '/scauth/login') {
            $this->seq += 2;
        } else {
            $this->seq += 1;
        }

        $response = $this->client->post('authenticate', [
            'verify' => $this->snapchat->shouldVerifyPeer(),
            'json' => [
                'ts' => $this->ts,
                'seq' => $seq,
                'username' => $username,
                'auth_token' => $authToken,
                'endpoint' => $endpoint
            ]
        ]);

        $status_code = $response->getStatusCode();
        $contents = $response->getBody()->getContents();

        if ($status_code != 200) {
            throw new PicabooooException("Invalid response code ($status_code) from Picaboooo, contents: $contents.");
        }

        return json_decode($contents, true);
    }
}