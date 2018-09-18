<?php

namespace Admin\Form\Signature\InputFilter;

use MainClass\MainInputFilter;

class SignatureInputFilter extends MainInputFilter
{
    public function __construct()
    {
        $this->add(
            $this->getValidationBaseForInputInt([
                'required' => true,
                'name' => 'plan_id'
            ])
        );

        $this->add(
            $this->getValidationBaseForInputInt([
                'required' => true,
                'name' => 'customer_id'
            ])
        );

        $this->add(
            $this->getValidationBaseForInputDateRange([
                'required' => true,
                'name' => 'date_range'
            ])
        );

        $this->add([
            'name' => 'movie',
            'required' => false,
            'filters' => $this->setFilters(['StripTags', 'StringTrim']),
        ]);

        $this->add(
            $this->getValidationBaseForInputBool([
                'required' => true,
                'name' => 'active'
            ])
        );
    }
}