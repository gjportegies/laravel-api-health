<?php

namespace Pbmedia\ApiHealth\Tests\TestCheckers;

use Pbmedia\ApiHealth\Checkers\Checker;
use Pbmedia\ApiHealth\Checkers\CheckerHasFailed;

class FailingAtEvenTimesChecker implements Checker
{
    public function run()
    {
        static $number;

        if (is_null($number)) {
            $number = 0;
        }

        if ($number % 2 == 0) {
            $number++;
            throw new CheckerHasFailed("TestChecker fails!");
        }

        $number++;
    }

    public static function create()
    {
        return new static;
    }
};