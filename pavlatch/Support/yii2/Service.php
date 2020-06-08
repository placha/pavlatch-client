<?php

namespace pavlatch\Support\yii2;

use pavlatch\Client;
use pavlatch\Support\SupportInterface;
use Yii;
use yii\base\Component;

class Service extends Component implements SupportInterface
{
    /**
     * @var string
     */
    public $serverUrl;

    /**
     * @var string
     */
    public $secureKey;

    /**
     * @var Client
     */
    private $client;

    public function init()
    {
        $this->client = new Client([
            'serverUrl' => $this->serverUrl,
            'secureKey' => $this->secureKey,
        ]);
    }

    public function upload(string $filename, string $source): bool
    {
        $result = $this->client->upload($filename, $source);
        Yii::debug('Pavlatch: ' . $this->client->lastError);

        return $result;
    }

    public function exist(string $filename): bool
    {
        $result = $this->client->exist($filename);
        Yii::debug('Pavlatch: ' . $this->client->lastError);

        return $result;
    }
}
