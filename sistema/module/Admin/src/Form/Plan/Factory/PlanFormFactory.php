<?php

namespace Admin\Form\Plan\Factory;

use Admin\Model\PlanTable;
use Interop\Container\ContainerInterface;
use Admin\Form\Plan\InputFilter\PlanInputFilter;
use Admin\Form\Plan\PlanForm;
use MainClass\MainController;

class PlanFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $planTable = $container->get(PlanTable::class);
        $plans = $planTable->fetchPlanCategory();
        $plans = MainController::getSelect($plans, ['id', 'name']);

        $form = new PlanForm($container);
        $form->get('category_id')->setValueOptions($plans);

        $inputFilter = new PlanInputFilter($plans);
        $form->setInputFilter($inputFilter);

        return $form;
    }
}