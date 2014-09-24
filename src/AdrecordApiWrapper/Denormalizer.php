<?php

namespace AdrecordApiWrapper;

class Denormalizer
{
    /**
     * @param array $channelsData
     *
     * @return Channel[]
     */
    public function denormalizeChannels(array $channelsData)
    {
        $channels = [];
        foreach ($channelsData as $channelData) {
            $channels[] = $this->denormalizeChannel($channelData);
        }

        return $channels;
    }

    /**
     * @param \stdClass $channelData
     *
     * @return Channel
     */
    public function denormalizeChannel(\stdClass $channelData)
    {
        $channel = new Channel();
        $channel->setId($channelData->channelID);
        $channel->setName($channelData->channelName);
        $channel->setUrl($channelData->channelUrl);

        return $channel;
    }
}
