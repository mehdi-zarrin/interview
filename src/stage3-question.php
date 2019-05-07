<?php
namespace App\Question\Something;
/*
Please take a look at the code below. We've got a class Fight, which implements a logic of a fight between two heroes.
After the fight one of the hero may lose some health points.
Please make an implementation of a test for Fight::makeFight() method.
Feel free to refactor a code if you think it's needed.
*/

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

//class FightTest extends TestCase {
//
//    public function tearDown()
//    {
//        Mockery::close();
//    }
//
//    public function testMakeFight()
//    {
//
//        $attacker = Mockery::mock('HeroInterface');
//        $attacker->shouldReceive('getHealthPoints')->once()->andReturn('getHealthPoints');
//
//        $defender = Mockery::mock('HeroInterface');
//        $attacker->shouldReceive('setHealthPoints')->with(1)->andReturn('setHealthPoints');
//
//        $damageCalculator = Mockery::mock('DamageCalculator');
//        $damageCalculator->shouldReceive('getDamage')->once()->with($attacker, $defender)->andReturn('calculated');
//
//    }
//}