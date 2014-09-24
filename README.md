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

$channel = $adrecord->getChannel(4);
echo sprintf('%d: %s (%s)%s', $channel->getId(), $channel->getName(), $channel->getUrl(), PHP_EOL);
//4: Hittajulklappar (http://www.hittajulklappar.se)

foreach ($adrecord->getPrograms() as $program) {
    echo sprintf('%d: %s (%s)%s', $program->getId(), $program->getName(), $program->getUrl(), PHP_EOL);
}
//43: Blogvertiser (http://www.blogvertiser.com/sv/)

$program = $adrecord->getProgram(43);
echo sprintf('%d: %s (%s)%s', $program->getId(), $program->getName(), $program->getUrl(), PHP_EOL);
//43: Blogvertiser (http://www.blogvertiser.com/sv/)
```

