<?php

namespace Managefaster\Database\Abstract;

use Illuminate\Auth\Authenticatable as Auth;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;


abstract class UuidAuthEncryptModel extends UuidEncryptModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Auth, Authorizable, CanResetPassword, MustVerifyEmail;
}