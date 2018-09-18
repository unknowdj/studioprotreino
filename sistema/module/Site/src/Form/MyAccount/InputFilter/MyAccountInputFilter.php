<?php

namespace Site\Form\MyAccount\InputFilter;

use MainClass\MainInputFilter;

/**
 * Class MyAccountInputFilter
 * @package Admin\Form\MyAccount\InputFilter
 */
class MyAccountInputFilter extends MainInputFilter
{

    /**
     * MyAccountInputFilter constructor.
     */
    public function __construct()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => $this->setFilters(['StripTags', 'StringTrim']),
            'validators' => [
                $this->validNotEmpty()
            ]
        ]);

        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => $this->setFilters(['StripTags', 'StringTrim']),
            'validators' => [
                $this->validNotEmpty()
            ]
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => $this->setFilters(['StripTags', 'StringTrim']),
            'validators' => [
                $this->validNotEmpty()
            ]
        ]);

        $this->add([
            'name' => 'password_confirmation',
            'required' => true,
            'filters' => $this->setFilters(['StripTags', 'StringTrim']),
            'validators' => [
                $this->validNotEmpty(),
                $this->validIdentical('password')

            ]
        ]);

        $this->add(
            $this->getValidationBaseForInputInt([
                'required' => true,
                'name' => 'age'
            ])
        );
    }

}