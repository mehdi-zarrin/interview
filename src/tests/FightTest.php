<?php

use App\Question\DamageCalculator;
use App\Question\Fight;
use App\Question\HeroInterface;
use PHPUnit\Framework\TestCase;

class FightTest extends TestCase
{
    public function testMakeFight() {
        $damageCalculatorStub = $this->createMock(DamageCalculator::class);
        $heroStub = $this->createMock(HeroInterface::class);
        $fight = new Fight;
        $this->assertIsInt(
            $fight->makeFight($heroStub, $heroStub, $damageCalculatorStub));
    }
}