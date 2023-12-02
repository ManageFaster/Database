<?php

namespace Managefaster\Database\Traits;

trait EncryptTrait
{
    private function encryptString($value): string {
        return $this->placeValuesToString(config('database.encrypt_attribute'), $value);
    }

    private function decryptString($value): string {
        return $this->placeValuesToString(config('database.decrypt_attribute'), $value);
    }

    public function decryptKey($column, $operator = '='): string {
        return $this->placeValuesToString(config('database.decrypt_key'), $column) . " $operator ?";
    }

    private function placeValuesToString($string, $value): string {
        return sprintf($string, $value, $this->encryptKey);
    }
}
