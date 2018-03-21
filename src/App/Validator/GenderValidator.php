<?php

namespace App\Validator;

use App\Entity\User;
use Core\Form\Validator\ValidatorInterface;

class GenderValidator implements ValidatorInterface
{
    public function validate($param): bool
    {
        return \in_array($param, [User::GENDER_MALE, User::GENDER_FEMALE], true);
    }

    public function getErrorMessage(): string
    {
        return sprintf('must be %s or %s', User::GENDER_FEMALE, User::GENDER_MALE);
    }
}