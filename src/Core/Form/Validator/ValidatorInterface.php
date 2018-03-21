<?php

namespace Core\Form\Validator;

interface ValidatorInterface
{
    public function validate($param): bool;

    public function getErrorMessage(): string;
}