<?php

namespace AdrecordApiWrapper;

use AdrecordApiWrapper\Exception\AuthenticationException;
use AdrecordApiWrapper\Exception\CommunicationException;
use Guzzle\Http\ClientInterface;

class Adrecord
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var \Guzzle\Http\ClientInterface
     */
    protected $client;

    /**
     * @var \AdrecordApiWrapper\Denormalizer
     */
    protected $denormalizer;

    /**
     * @param string          $key
     * @param ClientInterface $client
     */
    public function __construct($key, ClientInterface $client)
    {
        $this->key = $key;
        $this->client = $client;

        $this->denormalizer = new Denormalizer();
    }

    /**
     * @return Channel[]
     */
    public function getChannels()
    {
        return $this->denormalizer->denormalizeChannels($this->load('https://api.adrecord.com/v1/channels')->result);
    }

    /**
     * @param int $id
     *
     * @return Channel
     */
    public function getChannel($id)
    {
        return $this->denormalizer->denormalizeChannel(
            $this->load(sprintf('https://api.adrecord.com/v1/channels/%s', $id))->result
        );
    }

    /**
     * @return Program[]
     */
    public function getPrograms()
    {
        return $this->denormalizer->denormalizePrograms($this->load('https://api.adrecord.com/v1/programs')->result);
    }

    /**
     * @param int $id
     *
     * @return Program
     */
    public function getProgram($id)
    {
        return $this->denormalizer->denormalizeProgram(
            $this->load(sprintf('https://api.adrecord.com/v1/programs/%s', $id))->result
        );
    }

    /**
     * @param string $url
     * @throws Exception\AuthenticationException
     * @throws Exception\CommunicationException
     *
     * @return string
     */
    protected function load($url)
    {
        $response = $this->client->get($url, ['Apikey' => $this->key])->send();

        if (200 != $response->getStatusCode()) {
            throw new CommunicationException();
        }

        $body = json_decode($response->getBody());

        if ('error' == $body->status) {
            throw new AuthenticationException($body->message);
        }

        return $body;
    }
}
