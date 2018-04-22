<?php

namespace App\Api\Abstracts;

/**
 * Abstract class Lift
 * Emulates a lift logic
 */

abstract class AbstractLift implements \App\Api\Contracts\LiftInterface
{
    /**
     * @var bool is the lift moving
     */
    protected $movement = false;

    /**
     * @var int current floor number
     */
    protected $currentFloor = null;

    /**
     * @var null/int
     */
    protected $nextFloorStop = null;

    /**
     * @var string ''/'up'/'down'
     */
    protected $currentDirection = '';

    /**
     * @var array
     */
    protected $destinationsQueue = [];

    /**
     * @var int max allowed floor
     */
    protected $maxFloor;

    /**
     * @var int min allowed floor
     */
    protected $minFloor;

    /**
     * @param int $floorNumber
     * @return bool
     */
    public function setFloor($floorNumber)
    {
        $floorNumber = (int)$floorNumber;

        if (
            !is_int($floorNumber)
            || $floorNumber > $this->maxFloor
            || $floorNumber < $this->minFloor
        ) {
            return false;
        }

        if ($this->nextFloorStop) {
            array_push($this->destinationsQueue, $floorNumber);
            $this->destinationsQueue = array_unique($this->destinationsQueue);

            return true;
        }

        $this->nextFloorStop = $floorNumber;
        $this->run();
    }

    /**
     * @return bool
     */
    public function openDoor()
    {
        if ($this->movement) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function closeDoor()
    {
        if ($this->movement) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function callSupport()
    {
        return true;
    }

    /**
     * @return void
     */
    protected function run()
    {
        $this->setDirection();

        $this->closeDoor();
        $this->movement = true;

        if ($this->currentDirection === 'up') {
            for ($this->currentFloor; $this->currentFloor < $this->nextFloorStop; $this->currentFloor++) {}
        } elseif ($this->currentDirection === 'down') {
            for ($this->currentFloor; $this->currentFloor > $this->nextFloorStop; $this->currentFloor--) {}
        }

        $this->movement = false;
        $this->openDoor();
        $this->setNextDestination();
    }

    /**
     * @return void
     */
    protected function setNextDestination()
    {
        $sortedDestinations = $this->getSortedDestinationsQueue();

        if (!empty($sortedDestinations)) {
            $this->setDestination($sortedDestinations);
            $this->run();
        }

        $this->nextFloorStop = null;
        $this->currentDirection = '';
    }

    /**
     * @return array destinations sorted by directions 'up'/'down'
     */
    protected function getSortedDestinationsQueue()
    {
        $sortedDestinations = [];

        foreach ($this->destinationsQueue as $destination) {
            if ($this->currentFloor < $destination) {
                $sortedDestinations['up'][] = $destination;
            } elseif ($this->currentFloor > $destination) {
                $sortedDestinations['down'][] = $destination;
            }
        }

        return $sortedDestinations;
    }

    /**
     * @param $sortedDestinations
     * @return void
     */
    protected function setDestination($sortedDestinations) {
        if ($this->currentDirection === 'up' && !empty($sortedDestinations['up'])) {
            $this->nextFloorStop = min($sortedDestinations['up']);
            $this->destinationsQueue = array_diff($this->destinationsQueue, [$this->nextFloorStop]);
        } elseif ($this->currentDirection === 'down' && !empty($sortedDestinations['down'])) {
            $this->nextFloorStop = max($sortedDestinations['down']);
            $this->destinationsQueue = array_diff($this->destinationsQueue, [$this->nextFloorStop]);
        } elseif (!empty($sortedDestinations['up'])) {
            $this->nextFloorStop = min($sortedDestinations['up']);
            $this->destinationsQueue = array_diff($this->destinationsQueue, [$this->nextFloorStop]);
        } else {
            $this->nextFloorStop = max($sortedDestinations['down']);
            $this->destinationsQueue = array_diff($this->destinationsQueue, [$this->nextFloorStop]);
        }
    }

    /**
     * @return void
     */
    protected function setDirection() {
        if ($this->nextFloorStop > $this->currentFloor) {
            $this->currentDirection = 'up';
        } else {
            $this->currentDirection = 'down';
        }
    }
}