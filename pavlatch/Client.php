<?php

namespace pavlatch;

use GuzzleHttp\Exception\GuzzleException;
use pavlatch\Exception\ClientException;

/**
 * Class Client
 *
 * Usage:
 * $client = new pavlatch\Client([
 *     'serverUrl' => 'http://127.0.0.1/',
 *     'secureKey' => '6a4068f2-2cde-494d-90e1-08ba5827a677'
 * ])
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

    /**
     * Client constructor.
     * @param array $serverConfig
     * @throws ClientException
     */
    public function __construct(array $serverConfig)
    {
        $this->serverUrl = $serverConfig['serverUrl'] ?? null;
        $this->secureKey = $serverConfig['secureKey'] ?? null;

        if ($this->serverUrl === null || $this->secureKey === null) {
            throw new ClientException('Invalid configuration.');
        }

        $this->client = new \GuzzleHttp\Client();
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
            $response = $this->client->request('POST',
                $this->serverUrl,
                [
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
}
