<?php

namespace Site\Form\Customer\InputFilter;

use MainClass\MainInputFilter;

/**
 * Class CustomerInputFilter
 * @package Admin\Form\Customer\InputFilter
 */
class CustomerInputFilter extends MainInputFilter
{

    /**
     * CustomerInputFilter constructor.
     */
    public function __construct()
    {
        $this->add([
            'name' => 'plan_id',
            'required' => true,
            'filters' => $this->setFilters(['StripTags', 'StringTrim']),
            'validators' => [
                $this->validNotEmpty()
            ]
        ]);

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

        $this->add(
            $this->getValidationBaseForInputFloat([
                'required' => true,
                'name' => 'height'
            ])
        );
    }

}