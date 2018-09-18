<?php

namespace Site\Form\Login\InputFilter;

use MainClass\MainInputFilter;

/**
 * Class SignInInputFilter
 * @package Admin\Form\SignIn\InputFilter
 */
class SignInInputFilter extends MainInputFilter
{
    /**
     * SignInInputFilter constructor.
     */
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
            'required' => false,
            'filters' => $this->setFilters(['StripTags', 'StringTrim']),
            'validators' => [
                $this->validNotEmpty()
            ]
        ]);
    }
}