<?php

namespace Core\Form;

use Core\Form\Validator\ValidatorCollection;
use Core\Form\Validator\ValidatorInterface;
use Core\Http\Request\RequestInterface;

abstract class AbstractForm
{
    protected $error;

    abstract public function getValidatorCollection(): ValidatorCollection;

    public function validate(RequestInterface $request):bool
    {
        $collection = $this->getValidatorCollection();
        if (\count($collection) > 0) {
            /**
             * @var  string $param
             * @var ValidatorInterface $validator
             */
            foreach ($collection->getValidators() as list($param, $validator)) {
                if (!$validator->validate($request->getQueryParam($param))) {
                    $this->error = $validator->getErrorMessage();
                    return false;
                }
            }
        }

        return true;
    }

    public function getError()
    {
        return $this->error;
    }
}