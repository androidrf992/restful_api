<?php

namespace Core\Form\Validator;

class TextValidator implements ValidatorInterface
{
    public function validate($param): bool
    {
        return !empty($param);
    }

    public function getErrorMessage(): string
    {
        return 'Param cannot be blank';
    }
}