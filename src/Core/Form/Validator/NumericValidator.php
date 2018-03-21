<?php

namespace Core\Form\Validator;

class NumericValidator implements ValidatorInterface
{
    private $range;

    public function __construct($range = [])
    {
        $this->range = $range;
    }

    public function validate($param): bool
    {
        if (!filter_var($param, FILTER_VALIDATE_INT)) {
            return false;
        }
        if (!empty($this->range)) {
            return $param >= $this->range[0] && $param <= $this->range[1];
        }
    }

    public function getErrorMessage(): string
    {
        return 'Value must be integer' . !empty($this->range)
            ? sprintf(' and in range [%d, %d]', $this->range[0], $this->range[1])
            : '';
    }
}