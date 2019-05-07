<?php
use PHPUnit\Framework\TestCase;
use App\User;

class EmailTest extends TestCase
{
    public function testEmailIsString() {
        $user = new User;
        $this->assertTrue(method_exists($user, '__toString'));
    }
}