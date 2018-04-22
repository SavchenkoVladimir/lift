<?php

namespace App\Src;

/**
 * Class Lift
 * @package App\Src
 */
class Lift extends \App\Api\Abstracts\AbstractLift
{
    /**
     * Lift constructor.
     * @param int $lowestFloor
     * @param int $highestFloor
     * @param int $currentFloor
     */
    public function __construct($lowestFloor, $highestFloor, $currentFloor)
    {
        $this->maxFloor = $highestFloor;
        $this->minFloor = $lowestFloor;
        $this->currentFloor = $currentFloor;
    }

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
            echo 'Invalid floor number.' . PHP_EOL;
            return false;
        }

        if ($this->nextFloorStop) {
            array_push($this->destinationsQueue, $floorNumber);
            $this->destinationsQueue = array_unique($this->destinationsQueue);
            echo 'Queue is updated.';

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
            echo "Can't open the door while moving." . PHP_EOL;
            return false;
        }

        echo 'The door is opened. Current floor is: ' . $this->currentFloor . PHP_EOL;
        return true;
    }

    /**
     * @return bool
     */
    public function closeDoor()
    {
        if ($this->movement) {
            echo "Can't close the door because it is already closed." . PHP_EOL;
            return false;
        }

        echo 'Door is closed' . PHP_EOL;
        return true;
    }

    /**
     * @return bool
     */
    public function callSupport()
    {
        echo 'Support is called';
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
            for ($this->currentFloor; $this->currentFloor < $this->nextFloorStop; $this->currentFloor++) {
                echo 'Current floor is: ' . $this->currentFloor . PHP_EOL;
            }
        } elseif ($this->currentDirection === 'down') {
            for ($this->currentFloor; $this->currentFloor > $this->nextFloorStop; $this->currentFloor--) {
                echo 'Current floor is: ' . $this->currentFloor . PHP_EOL;
            }
        }

        $this->movement = false;
        $this->openDoor();
        $this->setNextDestination();
    }
}