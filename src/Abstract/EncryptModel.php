<?php

namespace Managefaster\Database\Abstract;

use Illuminate\Database\Eloquent\Model;
use Managefaster\Database\Facades\Database;

abstract class EncryptModel extends Model
{
    protected array $encrypts = [];

    public function getEncrypt(): array {
        return $this->encrypts;
    }

    public function checkIfAttributeIsEncrypted($attributeKey) {
        return in_array($attributeKey, $this->getEncrypt());
    }

    public function checkIfAttributeIsHidden($attributeKey) {
        return in_array($attributeKey, $this->getHidden());
    }

    public function setAttribute($key, $value) {
        if (in_array($key, $this->getEncrypt()) && !is_null($value))
            $value = Database::encrypt($value);

        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key) {
        $value = parent::getAttribute($key);

        // Check if the field is in the $encrypts array and needs decryption
        if ($this->checkIfAttributeIsEncrypted($key) && !is_null($value) && preg_match('/^[0-9a-fA-F]+$/', $value)) {
            return Database::decrypt($value);
        } else if ($this->checkIfAttributeIsEncrypted($key) && !is_null($value)) {
            $value = preg_replace("/^BINARY\(HEX\((AES_ENCRYPT\(N'(.+)', '(.+)'\))\)\)$/", "$2", $value);

            if(preg_match('/^[0-9a-fA-F]+$/', $value)) {
                return Database::decrypt($value);
            }
        }

        if($this->checkIfAttributeIsHidden($key))
            return null;

        return $value;
    }


    public function scopeWhereEncrypted($query, $column, $operator = null, $value = null, $boolean = 'and') {
         if (is_array($column)) {
            return Database::addArrayOfWheres($query, $column, $boolean);
         }

        [$value, $operator] = Database::prepareValueAndOperator($value, $operator, func_num_args() === 3);

        return Database::whereRaw($query, $column, $operator, $value, $boolean);
    }

    public function scopeOrWhereEncrypted($query, $column, $operator = null, $value = null) {
        [$value, $operator] = Database::prepareValueAndOperator($value, $operator, func_num_args() === 3);

        return $this->scopeWhereEncrypted($query, $column, $operator, $value, 'or');
    }

    public function scopeAndWhereEncrypted($query, $column, $operator, $value) {
        [$value, $operator] = Database::prepareValueAndOperator($value, $operator, func_num_args() === 3);

        return $this->scopeWhereEncrypted($query, $column, $operator, $value);
    }
}
