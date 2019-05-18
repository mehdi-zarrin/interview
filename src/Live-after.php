<?php

namespace App\Live\Solution;

class Car
{

    public $engine;

    /**
     * Car constructor.
     * @param $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    public function drive()
    {

        if ($this->engine->canBeStarted()) {
            return $this->engine->start();
        }
    }
}

interface EngineInterface
{
    public function start();
}

interface ChargeableInterface
{
    public function isBatteryEmpty(): bool;
}

interface FuelableInterface
{
    public function isTankEmpty(): bool;
}

interface StartableInterface
{
    public function CanBeStarted();
}


class Engine implements EngineInterface, ChargeableInterface, StartableInterface
{

    protected $batteryStatus;

    public function __construct(int $batteryStatus)
    {
        $this->batteryStatus = $batteryStatus;
    }

    public function start()
    {
        return 'Electric engine has started';
    }

    public function isBatteryEmpty(): bool
    {

        if ($this->batteryStatus == 0) {
            return true;
        }

        return false;
    }

    public function CanBeStarted()
    {
        if ($this->isBatteryEmpty()) {
            throw new \Exception('Please re-charge me');
        }

        return true;
    }
}

class FuelEngine implements StartableInterface, EngineInterface, FuelableInterface
{

    /**
     * @var int
     */
    private $fuelStatus;

    /**
     * FuelEngine constructor.
     * @param int $fuelStatus
     */
    public function __construct(int $fuelStatus)
    {
        $this->fuelStatus = $fuelStatus;
    }

    public function start()
    {
        return 'fuel engine has started';
    }

    public function CanBeStarted()
    {
        if ($this->isTankEmpty()) {
            throw new \Exception('Please take me to the gas station');
        }

        return true;
    }

    public function isTankEmpty(): bool
    {
        if ($this->fuelStatus == 0) {
            return true;
        }

        return false;
    }
}

// drive an electric car
$car = new Car(new Engine(10));

try {
    echo $car->drive() . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}


// drive a diesel car
$car = new Car(new FuelEngine(0));

try {
    echo $car->drive() . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}


