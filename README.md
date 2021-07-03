# Pavlatch Client

## Setup
```
{
  "require": {
    "kacperplacha/pavlatch-client": "^2.0.0"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/kacperplacha/pavlatch-client.git"
    }
  ]
}
```

## Example of usage
```
include __DIR__ . '/vendor/autoload.php';

$client = new \pavlatch\Client('http://127.0.0.1/pavlatchServer', 6a4068f2-2cde-494d-90e1-08ba5827a677');

$client->upload('foo.jpg', 'source.jpg');

$client->exist('foo.jpg');

$client->getLastError();
```

## Framework support

### Yii2
```
    'components' => [
        'pavlatch' => [
            'class'     => 'pavlatch\Support\yii2\Service',
            'serverUrl' => getenv('PAVLATCH_ADDRESS'),
            'secureKey' => getenv('PAVLATCH_SECURE_KEY'),
        ],
    ],
    
    Yii::$app->pavlatch->upload('foo.jpg', 'source.jpg');
```
