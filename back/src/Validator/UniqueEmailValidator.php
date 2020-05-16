<?php

namespace App\Validator;

use App\Service\UserService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEmailValidator extends ConstraintValidator
{
    /** @var UserService */
    private $userService;

    /**
     * UniqueUsernameValidator constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function validate($value, Constraint $constraint)
    {
        if (!empty($value) && $this->userService->findByEmail($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}