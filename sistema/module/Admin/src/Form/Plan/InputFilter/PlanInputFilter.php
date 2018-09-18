<?php

namespace Admin\Form\Plan\InputFilter;

use MainClass\MainInputFilter;

class PlanInputFilter extends MainInputFilter
{
    public function __construct($haystack)
    {
        $this->add(
            $this->getValidationBaseForSelectID([
                'name' => 'category_id'
            ], $haystack)
        );

        $this->add([
            'name' => 'title',
            'required' => true,
            'filters' => $this->setFilters(['StripTags', 'StringTrim']),
            'validators' => [
                $this->validNotEmpty()
            ]
        ]);

        $this->add([
            'name' => 'description',
            'required' => false,
            'filters' => $this->setFilters(['StripTags', 'StringTrim']),
            'validators' => [
            ]
        ]);

        $this->add(
            $this->getValidationBaseForInputMoney([
                'name' => 'value',
                'required' => true,
            ])
        );

        $this->add(
            $this->getValidationBaseForInputBool([
                'name' => 'active'
            ])
        );
    }
}