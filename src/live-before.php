<?php
namespace App\Live\Question;

class Car {
    public function drive() {
        $engine = new Engine;
        if($engine->getFuelType() == 'electric') {
            if($engine->isBatteryEmpty()) {
                throw new \Exception('Please re-charge me');
            }
        }

        $engine->start();
    }
}

class Engine {

    public function getFuelType() {
        // can return 'diseal', 'electric', etc
    }

    public function start() {

    }

    public function isBatteryEmpty() {

    }
}