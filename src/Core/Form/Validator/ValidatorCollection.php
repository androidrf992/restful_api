<?php

namespace Core\Form\Validator;

/**
 * Class ValidatorCollection used for collect all validation from from for next validate
 * @package Core\Form\Validator
 */
class ValidatorCollection implements \Countable
{
    private $validatorList = [];

    public function add($param, ValidatorInterface $validator)
    {
        $this->validatorList[] = [$param, $validator];
    }

    public function count(): int
    {
        return \count($this->validatorList);
    }

    public function getValidators(): array
    {
        return $this->validatorList;
    }
}