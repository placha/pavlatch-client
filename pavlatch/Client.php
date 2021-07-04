<?php

namespace pavlatch;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Client
 *
 * Usage:
 * $client = new pavlatch\Client('http://127.0.0.1/','6a4068f2-2cde-494d-90e1-08ba5827a677');
 * $client->upload();
 * $client->exist();
 *
 * @package pavlatch
 */
class Client
{
    public string $lastError;
    private string $secureKey;
    private GuzzleClient $client;

    public function __construct(string $serverUrl, string $secureKey)
    {
        $this->secureKey = $secureKey;
        $this->client = new GuzzleClient([
            'base_uri' => $serverUrl,
            'headers' => [
                'User-Agent' => 'Pavlatch Guzzle',
            ],
        ]);
    }

    public function upload(string $filename, string $source): bool
    {
        try {
            $response = $this->getClient()->post('',
                [
                    'multipart' => [
                        [
                            'name' => 'secureKey',
                            'contents' => $this->secureKey,
                        ],
                        [
                            'name' => 'FileContents',
                            'contents' => file_get_contents($source),
                            'filename' => $filename,
                        ],
                    ],
                ]
            );
        } catch (GuzzleException $e) {
            $this->lastError = $e->getMessage();

            return false;
        }


        return $response->getStatusCode() === 201;
    }

    public function exist(string $filename): bool
    {
        try {
            $response = $this->getClient()->head($filename);
        } catch (GuzzleException $e) {
            $this->lastError = $e->getMessage();

            return false;
        }

        return $response->getStatusCode() === 204;
    }

    private function getClient(): GuzzleClient
    {
        return $this->client;
    }
}
