# Pavlatch Client

## Example of usage
```
include __DIR__ . '/vendor/autoload.php';

$client = new \pavlatch\Client([
    'serverUrl' => 'http://127.0.0.1/pavlatchServer',
    'secureKey' => '6a4068f2-2cde-494d-90e1-08ba5827a677',
]);

$client->upload('foo.jpg', 'source.jpg');

$client->exist('foo.jpg');
```