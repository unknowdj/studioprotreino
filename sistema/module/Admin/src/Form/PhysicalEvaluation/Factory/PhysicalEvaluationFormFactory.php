<?php

namespace Admin\Form\PhysicalEvaluation\Factory;

use Interop\Container\ContainerInterface;
use Admin\Form\PhysicalEvaluation\InputFilter\PhysicalEvaluationInputFilter;
use Admin\Form\PhysicalEvaluation\PhysicalEvaluationForm;

class PhysicalEvaluationFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new PhysicalEvaluationInputFilter();
        $form = new PhysicalEvaluationForm($container);
        $form->setInputFilter($inputFilter);
        return $form;
    }
}