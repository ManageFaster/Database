<?php

namespace Managefaster\Database\Abstract;

use Managefaster\Database\Traits\UuidTrait;

abstract class UuidEncryptModel extends EncryptModel
{
    use UuidTrait;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    public function getUuid() {
        return $this->uuid;
    }
}
