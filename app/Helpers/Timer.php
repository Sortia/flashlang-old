<?php

namespace App\Helpers;

class Timer
{
    /**
     * @var float
     */
    protected static float $startTime;

    /**
     * @var float
     */
    protected static float $stopTime;

    /**
     * Start timer
     */
    public static function start(): void
    {
        self::$startTime = microtime(true);
    }

    /**
     * Stop timer
     */
    public static function stop(): void
    {
        self::$stopTime = microtime(true);
    }

    /**
     * Get time
     */
    public static function get(): float
    {
        return self::$stopTime - self::$startTime;
    }
}
