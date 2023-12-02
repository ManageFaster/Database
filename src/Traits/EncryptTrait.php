<?php

namespace Managefaster\Database\Traits;

trait EncryptTrait
{
    private function encryptString($value): string {
        return $this->placeValuesToString(config('database.encrypt_string'), $value);
    }

    private function decryptString($value): string {
        return $this->placeValuesToString(config('database.decrypt_string'), $value);
    }

    public function decryptKey($column, $operator = '='): string {
        return $this->decryptString($column) . " $operator ?";
    }

    private function placeValuesToString($string, $value) {
        return sprintf($string, $value, $this->encryptKey);
    }
}
