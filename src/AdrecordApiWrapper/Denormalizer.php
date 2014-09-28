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

    /**
     * @param array $transactionsData
     *
     * @return Transaction[]
     */
    public function denormalizeTransactions(array $transactionsData)
    {
        $transactions = [];
        foreach ($transactionsData as $transactionData) {
            $transactions[] = $this->denormalizeTransaction($transactionData);
        }

        return $transactions;
    }

    /**
     * @param \stdClass $transactionData
     *
     * @return Transaction
     */
    public function denormalizeTransaction(\stdClass $transactionData)
    {
        $transaction = new Transaction();
        $transaction->setId($transactionData->id);
        $transaction->setType($transactionData->type);
        if ($transactionData->click) {
            $transaction->setClickedAt(\DateTime::createFromFormat('Y-m-d H:i:s', $transactionData->click));
        }
        $transaction->setEpi($transactionData->epi);
        $program = new Program();
        $program->setId($transactionData->program->id);
        $program->setName($transactionData->program->name);
        $transaction->setProgram($program);
        $channel = new Channel();
        $channel->setId($transactionData->channel->id);
        $channel->setUrl($transactionData->channel->url);
        $transaction->setChannel($channel);
        $transaction->setOrderId($transactionData->orderID);
        $transaction->setOrderValue($transactionData->orderValue);
        $transaction->setCommission($transactionData->commission);
        $transaction->setCommissionName($transactionData->commissionName);

        $changes = [];
        foreach ($transactionData->changes as $data) {
            $transactionChange = new TransactionChange();
            $transactionChange->setCreatedAt(\DateTime::createFromFormat('Y-m-d H:i:s', $data->date));
            $transactionChange->setType($data->type);
            if (isset($data->from)) {
                $transactionChange->setFrom($data->from);
            }
            if (isset($data->to)) {
                $transactionChange->setTo($data->to);
            }

            $changes[] = $transactionChange;
        }
        $transaction->setChanges($changes);

        $transaction->setPlatform($transactionData->platform);
        $transaction->setStatus($transactionData->status);

        return $transaction;
    }
}
