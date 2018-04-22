<?php

namespace App\Src;

/**
 * Class Test
 * Tests class house
 * @package App\Src
 */
class Test
{
    /**
     * @var \App\Src\house
     */
    protected $house;

    public function __construct()
    {
        $this->house = new House();
    }

    /**
     * Runs all test methods
     * @return void
     */
    public function run()
    {
        $classMethods = get_class_methods($this);
        $testMethods = array_diff($classMethods,['__construct', 'run']);
        foreach ($testMethods as $testMethod) {
            $this->$testMethod();
        }
    }

    /**
     * @return void
     */
    protected function negative()
    {
        $res1 = $this->house->callLift(16);
        $res2 = $this->house->callLift(0);

        if (!$res1 && !$res2) {
            echo 'Negative test success.' . PHP_EOL;
        } else {
            echo 'Negative test failed.' . PHP_EOL;
        }
    }

    /**
     * @throws \ErrorException
     */
    protected function positive()
    {
        try{
            $this->house->callLift(8);
            $this->house->callLift(15);
            $this->house->callLift(7);
            $this->house->callLift(2);
            $this->house->callLift(4);
            $this->house->callLift(7);
            $this->house->callLift(3);
            $this->house->callLift(12);
        } catch (\ErrorException $e) {
            echo 'Positive test failed.' . PHP_EOL;
            echo $e->getMessage() . PHP_EOL;
        }
        echo 'Positive test success.' . PHP_EOL;
    }
}