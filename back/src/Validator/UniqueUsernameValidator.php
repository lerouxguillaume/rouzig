<?php


namespace App\Validator;


use App\Service\UserService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


/**
 * Class UniqueUsernameValidator
 * @package App\Validator
 *
 * @Annotation
 */
class UniqueUsernameValidator extends ConstraintValidator
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
        if (!empty($value) && $this->userService->findByUsername($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}