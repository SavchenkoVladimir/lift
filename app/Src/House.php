<?php

namespace App\Src;

class House extends \App\Api\Abstracts\AbstractHouse
{
    /**
     * @var int
     */
    protected $highestFloor;

    /**
     * @var int
     */
    protected $lowestFloor;

    /**
     * @var object
     */
    protected $lift;

    public function __construct()
    {
        $this->highestFloor = 15;
        $this->lowestFloor = 1;
        $this->lift = new Lift($this->lowestFloor, $this->highestFloor, $this->lowestFloor);
    }

    /**
     * @param int $floor
     * @return void
     */
    public function callLift($floor)
    {
        $this->lift->setFloor($floor);
    }
}