<?php
// There is a code supporting calculation if a car is damaged.
// Now it should be extended to support calculating if a painting of car's exterior is damaged (this means, if a painting of any of car details is not OK - for example a door is scratched).

interface PaintableInterface {
    public function isPaintingDamaged(): bool;
}
interface BrokableInterface {
    public function isBroken(): bool;
}

interface DamagableInterface {
    public function canBeDamaged();
}

abstract class CarDetail {

    protected $isBroken;

    public function __construct(bool $isBroken)
    {
        $this->isBroken = $isBroken;
    }
}
// since Door is not paintable its implementing PaintableInterface and BrokableInterface
class Door extends CarDetail implements BrokableInterface, PaintableInterface, DamagableInterface
{

    public function isPaintingDamaged(): bool
    {
        return true;
    }

    public function isBroken(): bool
    {
        return $this->isBroken;
    }

    public function canBeDamaged()
    {
        return $this->isBroken() || $this->isPaintingDamaged() ? true : false;
    }
}
// since tyre is not paintable its not implementing PaintableInterface
class Tyre extends CarDetail implements BrokableInterface, DamagableInterface
{

    public function isBroken(): bool
    {
        return $this->isBroken;
    }

    public function canBeDamaged()
    {
        return $this->isBroken();
    }
}


class Car
{

    /**
     * @var CarDetail[]
     */
    private $details;

    /**
     * @param CarDetail[] $details
     */
    public function __construct(array $details)
    {
        $this->details = $details;
    }

    public function isBroken(): bool
    {
    	foreach ($this->details as $detail) {
            if ($detail->canBeDamaged()) {
                return true;
            }
        }

        return false;
    }
}
$car = new Car([new Door(false), new Tyre(false)]);