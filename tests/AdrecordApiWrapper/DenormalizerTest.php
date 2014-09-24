<?php

use AdrecordApiWrapper\Denormalizer;

class DenormalizerTest extends PHPUnit_Framework_TestCase
{
    public function testDenormalizeChannel()
    {
        $channelData = (object) [
            'channelID' => 4,
            'channelName' => 'Hittajulklappar',
            'channelUrl' => 'http://www.hittajulklappar.se',
            'programs' => [
                [
                    'programName' => 'Roliga Prylar',
                    'programID' => 193,
                ],
            ],
        ];

        $channel = (new Denormalizer())->denormalizeChannel($channelData);

        $this->assertInstanceOf('\AdrecordApiWrapper\Channel', $channel);
        $this->assertEquals(4, $channel->getId());
        $this->assertEquals('Hittajulklappar', $channel->getName());
        $this->assertEquals('http://www.hittajulklappar.se', $channel->getUrl());
    }

    public function testDenormalizeChannels()
    {
        $channelData = [(object)[
            'channelID' => 4,
            'channelName' => 'Hittajulklappar',
            'channelUrl' => 'http://www.hittajulklappar.se',
        ]];

        $channels = (new Denormalizer())->denormalizeChannels($channelData);

        $this->assertInstanceOf('\AdrecordApiWrapper\Channel', $channels[0]);
        $this->assertEquals(4, $channels[0]->getId());
        $this->assertEquals('Hittajulklappar', $channels[0]->getName());
        $this->assertEquals('http://www.hittajulklappar.se', $channels[0]->getUrl());
    }
}
