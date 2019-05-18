<?php
namespace App\Test;

use PHPUnit\Framework\TestCase;

interface HeroInterface
{
    public function getForce(): int;

    public function getImmunity(): int;

    public function getHealthPoints(): int;

    public function setHealthPoints(int $healthPoints);
}

class DamageCalculator
{
    const DAMAGE_RAND_FACTOR = 0.2;

    public function getDamage(HeroInterface $attacker, HeroInterface $defender)
    {
        if ($attacker->getForce() < $defender->getForce()) {
            return 0;
        }

        $damageBase = round(($attacker->getForce() - $defender->getForce()) / $defender->getImmunity());

        $damageFactor = $damageBase * self::DAMAGE_RAND_FACTOR;
        $minDamage    = $damageBase - $damageFactor;
        $maxDamage    = $damageBase + $damageFactor;

        return mt_rand($minDamage, $maxDamage);
    }
}

class Fight
{
    /**
     * @var DamageCalculator
     */
    private $damageCalculator;

    public function __construct(DamageCalculator $damageCalculator)
    {
        $this->damageCalculator = $damageCalculator;
    }

    public function makeFight(HeroInterface $attacker, HeroInterface $defender)
    {
        $damage = $this->damageCalculator->getDamage($attacker, $defender);

        $defender->setHealthPoints($defender->getHealthPoints()-$damage);
    }
}

class DamageControllerTest extends TestCase
{
    public function testGetDamage()
    {
        $attacker = $this->prophesize(HeroInterface::class);
        $attacker->getForce()->willReturn(5)->shouldBeCalled();

        $defender = $this->prophesize(HeroInterface::class);
        $defender->getForce()->willReturn(10)->shouldBeCalled();

        $controller = new DamageCalculator();
        $result     = $controller->getDamage($attacker->reveal(), $defender->reveal());

        $this->assertEquals(0, $result);
    }
}

class FightTest extends TestCase
{
    public function testMakeFight()
    {
        $attacker = $this->prophesize(HeroInterface::class)->reveal();

        $defender = $this->prophesize(HeroInterface::class);
        $defender->getHealthPoints()->willReturn(30)->shouldBeCalled();
        $defender->setHealthPoints(20)->shouldBeCalled();
        $defender = $defender->reveal();

        $controller = $this->prophesize(DamageCalculator::class);
        $controller->getDamage($attacker, $defender)->willReturn(10)->shouldBeCalled();

        $fight = new Fight($controller->reveal());
        $fight->makeFight($attacker, $defender);
    }
}