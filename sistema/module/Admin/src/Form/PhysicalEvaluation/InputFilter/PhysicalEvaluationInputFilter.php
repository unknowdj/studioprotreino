<?php

namespace Admin\Form\PhysicalEvaluation\InputFilter;

use MainClass\MainInputFilter;

class PhysicalEvaluationInputFilter extends MainInputFilter
{
    public function __construct()
    {
        $this->add(
            $this->getValidationBaseForInputDate([
                'name' => 'date',
                'required' => true,
            ])
        );

        $this->add(
            $this->getValidationBaseForInputFloat([
                'name' => 'weight',
                'required' => true,
            ])
        );

        $this->add(
            $this->getValidationBaseForInputFloat([
                'name' => 'fat_porcentage',
                'required' => true,
            ])
        );

        $this->add(
            $this->getValidationBaseForInputFloat([
                'name' => 'muscle_mass_porcentage',
                'required' => true,
            ])
        );
    }
}