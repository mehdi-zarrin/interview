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
    private $damageCalculator;
    public function __construct(DamageCalculator $damageCalculator) {
        $this->damageCalculator = $damageCalculator;
    }

    public function makeFight(HeroInterface $attacker, HeroInterface $defender)
    {
        $damage = $this->damageCalculator->getDamage($attacker, $defender);
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
        $attacker = Mockery::mock(HeroInterface::class);
        $defender = Mockery::mock(HeroInterface::class);
        $defender->shouldReceive('setHealthPoints')->once();
        $defender->shouldReceive('getHealthPoints')->once()->andReturn(20);

        $damageCalculator = Mockery::mock(DamageCalculator::class);
        $damageCalculator->shouldReceive('getDamage')->with($attacker, $defender)->once()->andReturn(10);

        $fight = new Fight($damageCalculator);
        $fight->makeFight($attacker, $defender);
        $this->assertTrue(true);
    }


    public function testDamageCalculator() 
    {
        $attacker = Mockery::mock(HeroInterface::class);
        $attacker->shouldReceive('getForce')->times(2)->andReturn(10);
        $defender = Mockery::mock(HeroInterface::class);
        $defender->shouldReceive('getForce')->times(2)->andReturn(10);
        $defender->shouldReceive('getImmunity')->once()->andReturn(1);
        $this->assertEquals(0, (new DamageCalculator)->getDamage($attacker, $defender));
    }
}