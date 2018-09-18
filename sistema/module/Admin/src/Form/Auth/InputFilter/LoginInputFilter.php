<?php

namespace Admin\Form\Auth\InputFilter;

use MainClass\MainInputFilter;

class LoginInputFilter extends MainInputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'user',
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
    }
}