<?php

namespace App\Api\Contracts;

interface LiftInterface
{
    /**
     * @param int $floorNumber
     * @return mixed
     */
    public function setFloor($floorNumber);

    /**
     * @return boolean
     */
    public function openDoor();

    /**
     * @return boolean
     */
    public function closeDoor();

    /**
     * @return boolean
     */
    public function callSupport();
}