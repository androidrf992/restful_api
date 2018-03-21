<?php

namespace Core\Form;

use Core\Form\Validator\ValidatorCollection;
use Core\Form\Validator\ValidatorInterface;
use Core\Http\Request\RequestInterface;

/**
 * Template class for validation request data
 *
 * @package Core\Form
 */
abstract class AbstractForm
{
    protected $error;

    protected $errorField;

    /**
     * Action for getting validation rules from custom forms
     *
     * @return ValidatorCollection
     */
    abstract public function getValidatorCollection(): ValidatorCollection;

    /**
     * Templete method for all forms
     *
     * @param RequestInterface $request
     * @return bool
     */
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
                    $this->errorField = $param;
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get error message from form validation
     *
     * @return string
     */
    public function getError(): string
    {
        return "{$this->errorField} - " . $this->error;
    }
}