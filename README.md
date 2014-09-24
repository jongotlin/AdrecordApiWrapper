AdrecordApiWrapper
==================

Php wrapper for Adrecord's api

```php
use AdrecordApiWrapper\Adrecord;
use Guzzle\Http\Client;

$client = new Client();
$adrecord = new Adrecord('36Ju9EWnFvplyqxV', $client);

foreach ($adrecord->getChannels() as $channel) {
    echo sprintf('%d: %s (%s)%s', $channel->getId(), $channel->getName(), $channel->getUrl(), PHP_EOL);
}
//4: Hittajulklappar (http://www.hittajulklappar.se)

echo PHP_EOL;

$channel = $adrecord->getChannel(4);
echo sprintf('%d: %s (%s)%s', $channel->getId(), $channel->getName(), $channel->getUrl(), PHP_EOL);
//4: Hittajulklappar (http://www.hittajulklappar.se)
```
