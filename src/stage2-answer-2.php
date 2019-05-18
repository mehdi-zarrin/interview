<?php

interface PaintableInterface {
    public function hasScratch(): bool;
}

abstract class CarDetail {

    protected $isBroken;

    public function __construct(bool $isBroken)
    {
        $this->isBroken = $isBroken;
    }

    public function isBroken(): bool
    {
        return $this->isBroken;
    }
}

class Door extends CarDetail implements PaintableInterface
{
    /**
     * @var bool
     */
    private $hasScratch;

    public function __construct(bool $isBroken, bool $hasScratch)
    {
        parent::__construct($isBroken);
        $this->hasScratch = $hasScratch;
    }

    public function hasScratch(): bool
    {
        return $this->hasScratch;
    }
}

class Tyre extends CarDetail
{
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

            if(
                $detail instanceof PaintableInterface &&
                $this->isPaintingDamaged($detail)
            ) {
                return true;
            }

            if ($detail->isBroken()) {
                return true;
            }
        }

        return false;
    }

    public function isPaintingDamaged(PaintableInterface $paintable): bool
    {
        return $paintable->hasScratch();
    }
}

$car = new Car([new Door(false, true), new Tyre(false)]); 

