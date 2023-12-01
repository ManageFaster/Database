<?php

namespace Managefaster\Database\Abstract;

abstract class Facade
{
    abstract public static function definition(): string;

    public static function __callStatic(string $method, array $args)
    {
        $resolvedService = app(static::definition());

        return $resolvedService->{$method}(...$args);
    }
}
