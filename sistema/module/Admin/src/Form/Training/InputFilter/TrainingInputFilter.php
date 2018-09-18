<?php

namespace Admin\Form\Training\InputFilter;

use MainClass\MainInputFilter;

/**
 * Class TrainingInputFilter
 * @package Admin\Form\Training\InputFilter
 */
class TrainingInputFilter extends MainInputFilter
{
    /**
     * TrainingInputFilter constructor.
     */
    public function __construct()
    {
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

        $this->add([
            'name' => 'training_id',
            'required' => false,
            'filters' => $this->setFilters(['StripTags', 'StringTrim', 'ToNull', 'Digits']),
            'validators' => [
                self::validNotEmpty(),
                self::validDigits()
            ]
        ]);

        $this->add(
            $this->getValidationBaseForInputBool([
                'name' => 'active'
            ])
        );
    }
}