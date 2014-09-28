<?php

namespace AdrecordApiWrapper;

class TransactionChange
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var int
     */
    protected $from;

    /**
     * @var int
     */
    protected $to;

    public function __construct()
    {
        $this->from = null;
        $this->to = null;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param int $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param int $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return int
     */
    public function getTo()
    {
        return $this->to;
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
}
