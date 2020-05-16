<?php

namespace App\Validator;

use App\Enum\ErrorCodes;
use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueUsername
 * @package App\Validator
 *
 * @Annotation
 */
class UniqueUsername extends Constraint
{
    public $message = ErrorCodes::USERNAME_ALREADY_USED;
}