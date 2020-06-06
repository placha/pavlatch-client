<?php

namespace pavlatch;

use pavlatch\Exception\ClientException;

/**
 * Class Client
 *
 * Usage:
 * new pavlatch\Client([
 *     'url' => 'http://127.0.0.1/',
 *     'secureKey' => '6a4068f2-2cde-494d-90e1-08ba5827a677'
 * ])
 *
 * @package pavlatch
 */
class Client
{
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
        $response = $this->client->request('POST',
            $this->serverUrl,
            [
                'multipart' => [
                    [
                        'name' => 'FileContents',
                        'contents' => file_get_contents(__DIR__ . '/../' . $source),
                        'filename' => $filename,
                    ],
                    [
                        'name' => 'secureKey',
                        'contents' => $this->secureKey,
                    ]
                ],
            ]
        );

        var_dump($response->getBody()->getContents());

        return $response->getStatusCode() === 200;
    }


//    /**
//     * Create a new stream based on the input type.
//     *
//     * @param resource|string|StreamInterface $source path to a local file, resource or stream
//     *
//     * @return StreamInterface
//     */
//    protected function sourceToStream($source): StreamInterface
//    {
//        if (is_string($source)) {
//            $source = Psr7\try_fopen($source, 'r+');
//        }
//
//        return Psr7\stream_for($source);
//    }
}
