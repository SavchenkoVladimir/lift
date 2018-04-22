<?php

namespace App\Api\Abstracts;

abstract class AbstractHouse implements \App\Api\Contracts\HouseInterface
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

    /**
     * Calls a lift from a specific floor
     * @param int $floor
     * @return bool
     */
    public abstract  function callLift($floor);

    /**
     * @return int $highestFloor
     */
    public function getHighestFloor()
    {
        return $this->highestFloor;
    }

    /**
     * @return int $lowestFloor
     */
    public function getLowestFloor()
    {
        return $this->lowestFloor;
    }
}