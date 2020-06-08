<?php

namespace pavlatch;

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
    /**
     * @var string
     */
    public $lastError;

    /**
     * @var string
     */
    private $serverUrl;

    /**
     * @var string
     */
    private $secureKey;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct(string $serverUrl, string $secureKey)
    {
        $this->serverUrl = $serverUrl;
        $this->secureKey = $secureKey;
    }

    public function upload(string $filename, string $source): bool
    {
        $code = $this->request([
            [
                'name' => 'FileContents',
                'contents' => file_get_contents($source),
                'filename' => $filename,
            ],
        ]);

        return $code === 201;
    }

    public function exist(string $filename): bool
    {
        $code = $this->request([
            [
                'name' => 'action',
                'contents' => 'exist',
            ],
            [
                'name' => 'filename',
                'contents' => $filename,
            ],
        ]);

        return $code === 204;
    }

    private function request(array $data): ?int
    {
        try {
            $response = $this->getClient()->request('POST', '',
                [
                    'headers' => [
                        'User-Agent' => 'Pavlatch Guzzle',
                    ],
                    'multipart' => array_merge(
                        [[
                            'name' => 'secureKey',
                            'contents' => $this->secureKey,
                        ]],
                        $data
                    )
                ]
            );
        } catch (GuzzleException $e) {
            $this->lastError = $e->getMessage();

            return null;
        }

        return $response->getStatusCode();
    }

    private function getClient(): \GuzzleHttp\Client
    {
        if ($this->client === null) {
            $this->client = new \GuzzleHttp\Client(['base_uri' => $this->serverUrl]);
        }

        return $this->client;
    }
}
