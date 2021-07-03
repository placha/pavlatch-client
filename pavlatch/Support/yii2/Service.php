<?php

namespace pavlatch\Support\yii2;

use pavlatch\Client;
use pavlatch\Support\SupportInterface;
use Yii;
use yii\base\Component;

class Service extends Component implements SupportInterface
{
    public string $serverUrl;
    public string $secureKey;
    private Client $client;

    public function init()
    {
        $this->client = new Client($this->serverUrl, $this->secureKey);
    }

    public function upload(string $filename, string $source): bool
    {
        return $this->client->upload($filename, $source);
    }

    public function exist(string $filename): bool
    {
        return $this->client->exist($filename);
    }

    public function getLastError(): ?string
    {
        return $this->client->lastError;
    }
}
