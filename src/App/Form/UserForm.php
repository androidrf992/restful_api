<?php

namespace App\Form;

use App\Validator\GenderValidator;
use Core\Form\AbstractForm;
use Core\Form\Validator\NumericValidator;
use Core\Form\Validator\TextValidator;
use Core\Form\Validator\ValidatorCollection;

class UserForm extends AbstractForm
{
    public function getValidatorCollection(): ValidatorCollection
    {
        $collection = new ValidatorCollection();
        $collection->add('name', new TextValidator());
        $collection->add('age', new NumericValidator([0, 150]));
        $collection->add('address', new TextValidator());
        $collection->add('gender', new GenderValidator());

        return $collection;
    }
}