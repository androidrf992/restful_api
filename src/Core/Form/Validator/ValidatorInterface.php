<?php

namespace Core\Form\Validator;

/**
 * General validator interface for AbstractForm
 *
 * @package Core\Form\Validator
 */
interface ValidatorInterface
{
    public function validate($param): bool;

    public function getErrorMessage(): string;
}