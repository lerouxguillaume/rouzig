<?php

namespace App\Validator;

use App\Enum\ErrorCodes;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueEmail extends Constraint
{
    public $message = ErrorCodes::EMAIL_ALREADY_USED;
}