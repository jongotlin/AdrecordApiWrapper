<?php

namespace AdrecordApiWrapper;

use AdrecordApiWrapper\Enum\TransactionType;
use AffiliateInterface\TransactionInterface;

class Transaction implements TransactionInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \DateTime
     */
    protected $clickedAt;

    /**
     * @var string
     */
    protected $epi;

    /**
     * @var Program
     */
    protected $program;

    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var int
     */
    protected $orderValue;

    /**
     * @var int
     */
    protected $commission;

    /**
     * @var string
     */
    protected $commissionName;

    /**
     * @var TransactionChange[]
     */
    protected $changes;

    /**
     * @var string
     */
    protected $platform;

    /**
     * @var int
     */
    protected $status;

    public function __construct()
    {
        $this->clickedAt = null;
    }

    /**
     * @param TransactionChange[] $changes
     */
    public function setChanges($changes)
    {
        $this->changes = $changes;
    }

    /**
     * @return TransactionChange[]
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param \AdrecordApiWrapper\Channel $channel
     */
    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return \AdrecordApiWrapper\Channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param \DateTime $clickedAt
     */
    public function setClickedAt(\DateTime $clickedAt)
    {
        $this->clickedAt = $clickedAt;
    }

    /**
     * @return \DateTime
     */
    public function getClickedAt()
    {
        return $this->clickedAt;
    }

    /**
     * @param int $commission
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
    }

    /**
     * @return int
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param string $commissionName
     */
    public function setCommissionName($commissionName)
    {
        $this->commissionName = $commissionName;
    }

    /**
     * @return string
     */
    public function getCommissionName()
    {
        return $this->commissionName;
    }

    /**
     * @param string $epi
     */
    public function setEpi($epi)
    {
        $this->epi = $epi;
    }

    /**
     * @return string
     */
    public function getEpi()
    {
        return $this->epi;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOriginalId()
    {
        return $this->getId();
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderValue
     */
    public function setOrderValue($orderValue)
    {
        $this->orderValue = $orderValue;
    }

    /**
     * @return int
     */
    public function getOrderValue()
    {
        return $this->orderValue;
    }

    /**
     * @param string $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param \AdrecordApiWrapper\Program $program
     */
    public function setProgram(Program $program)
    {
        $this->program = $program;
    }

    /**
     * @return \AdrecordApiWrapper\Program
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \DateTime
     * 
     * @throws \LogicException
     */
    public function getCreatedAt()
    {
        foreach ($this->getChanges() as $change) {
            if (TransactionType::TRANSACTION_REGISTERED == $change->getType()) {
                return $change->getCreatedAt();
            }
        }

        throw new \LogicException('Could not find created at date');
    }
}


