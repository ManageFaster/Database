<?php

namespace Managefaster\Database\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Managefaster\Database\Traits\EncryptTrait;

class DatabaseService
{
    use EncryptTrait;

    protected $encryptKey= '';

    public $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>', '&~', 'is', 'is not',
        'rlike', 'not rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];

    public function __construct() {
        $this->encryptKey = config('database.encrypt_key');

        if(empty($this->encryptKey))
            throw new \Exception('Set environment variable: ENCRYPT_KEY to random string');
    }

    public function encrypt(string|null|int|float $value): Expression {
        return DB::raw($this->encryptString($value));
    }

    public function decrypt(string|null|int|float $value) {
        return DB::select("SELECT {$this->decryptString($value)} AS decrypted_value")[0]->decrypted_value;
    }

    public function whereRaw(Builder $query, string $column, string $operator, string|null|int|float $value, $boolean = 'and'): Builder {
        return $query->whereRaw($this->decryptKey($column, $operator), [$value], $boolean);
    }

    public function addArrayOfWheres(Builder $query, $columns, $boolean) {

        foreach ($columns as $column) {
            $key = '';
            $operator = '=';
            $value = '';

            if(count($column) === 2) {
                $key = $column[0];
                $value = $column[1];
            }

            if(count($column) === 3) {
                $key = $column[0];
                $operator = $column[1];
                $value = $column[2];
            }

            $query->whereRaw($this->decryptKey($key, $operator), [$value], $boolean);
        }

        return $query;
    }

    public function prepareValueAndOperator($value, $operator, $useDefault = false)
    {
        if ($useDefault) {
            return [$operator, '='];
        } elseif ($this->invalidOperatorAndValue($operator, $value)) {
            throw new InvalidArgumentException('Illegal operator and value combination.');
        }

        return [$value, $operator];
    }

    protected function invalidOperatorAndValue($operator, $value) {
        return is_null($value) && in_array($operator, $this->operators) &&
            !in_array($operator, ['=', '<>', '!=']);
    }
}
