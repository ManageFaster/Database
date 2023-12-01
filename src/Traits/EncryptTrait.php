<?php

namespace Managefaster\Database\Traits;

trait EncryptTrait
{
    private function encryptString($value): string {
        return "BINARY(HEX(AES_ENCRYPT(N'$value', '$this->encryptKey')))";
    }

    private function decryptString($value): string {
//        return "CONVERT(AES_DECRYPT(BINARY(UNHEX($value)), '{$this->encryptKey}') USING UTF8)";
        return "AES_DECRYPT(UNHEX('$value'), '$this->encryptKey')";
    }

    public function decryptKey($column, $operator = '='): string {
        return "CONVERT(AES_DECRYPT(BINARY(UNHEX($column)), '{$this->encryptKey}') USING UTF8) $operator ?";
    }
}
