<?php

namespace Managefaster\Database\Facades;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Expression;
use Managefaster\Database\Abstract\Facade;
use Managefaster\Database\Services\DatabaseService;

class Database extends Facade
{
    /**
     * @method static Expression encrypt(string|null|int|float $value)
     * @method static decrypt(string|null|int|float $value)
     * @method static Builder whereRaw(Builder $query, string $column, string $operator, string|null|int|float $value, $boolean = 'and')
     * @method static addArrayOfWheres(Builder $query, $columns, $boolean)
     * @method static prepareValueAndOperator($value, $operator, $useDefault = false)
     * @method static string decryptKey($column, $operator = '=')
     *
     * @return string
     */
    public static function definition(): string {
        return DatabaseService::class;
    }
}
