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

    /**
     * @param array $programsData
     *
     * @return Program[]
     */
    public function denormalizePrograms(array $programsData)
    {
        $programs = [];
        foreach ($programsData as $programData) {
            $programs[] = $this->denormalizeProgram($programData);
        }

        return $programs;
    }

    /**
     * @param \stdClass $programData
     *
     * @return Program
     */
    public function denormalizeProgram(\stdClass $programData)
    {
        $program = new Program();
        $program->setId($programData->id);
        $program->setName($programData->name);
        $program->setUrl($programData->url);
        $program->setCategory($programData->category);

        return $program;
    }
}
