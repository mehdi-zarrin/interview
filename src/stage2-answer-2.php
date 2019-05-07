<?php
namespace App\Answer\Second;

/**
 * Please Note: there is another implementation of this which is more in tune with SOLID and uses
 * Interface Segregation. please checkout at: https://github.com/mehdi-zarrin/interview/blob/master/src/stage2-answer.php
 */

/**
 * Interface PaintableInterface
 * @package App\Answer\Second
 */
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

            if($detail instanceof PaintableInterface) {
                return $this->isPaintingDamaged();
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

$car = new Car([new Door(true, true), new Tyre(false)]); // we pass a list of all details
// ```

// Expected result: an implemented code.

// Note: you are allowed (and encouraged) to change anything in the existing code in order to make an implementation SOLID compliant