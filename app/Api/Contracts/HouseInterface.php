<?php

namespace App\Api\Contracts;

interface HouseInterface
{
    /**
     * @return integer $highestFloor
     */
    public function getHighestFloor();

    /**
     * @return integer $lowestFloor
     */
    public function getLowestFloor();
}