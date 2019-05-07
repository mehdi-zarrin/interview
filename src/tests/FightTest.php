<?php
namespace App\Test;
use PHPUnit\Framework\TestCase;
use Mockery;

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

    public function makeFight(HeroInterface $attacker, HeroInterface $defender, DamageCalculator $damageCalculator)
    {
        $damage = $damageCalculator->getDamage($attacker, $defender);
        $defender->setHealthPoints($defender->getHealthPoints()-$damage);
    }
}

class FightTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testMakeFight()
    {
        $attacker = Mockery::mock('HeroInterface');
        $attacker->shouldReceive('getHealthPoints')->once()->andReturn(1);

        $defender = Mockery::mock('HeroInterface');
        $attacker->shouldReceive('setHealthPoints')->with(1);

        $damageCalculator = Mockery::mock('DamageCalculator');
        $damageCalculator->shouldReceive('getDamage')->once()->with($attacker, $defender)->andReturn('calculated');

        $fight = new Fight;
        $fight->makeFight($attacker, $defender, $damageCalculator);

    }
}