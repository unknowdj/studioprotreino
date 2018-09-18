<?php

namespace Site\Form\Customer\Factory;

use Admin\Model\PlanTable;
use Interop\Container\ContainerInterface;
use MainClass\MainController;
use Site\Form\Customer\CustomerForm;
use Site\Form\Customer\InputFilter\CustomerInputFilter;

class CustomerFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $planTable = $container->get(PlanTable::class);
        $plans = $planTable->fetchPlanActive();
        $plans = MainController::getSelect($plans, ['id', ['category', 'title']], false);

        $form = new CustomerForm($container);
        $form->get('plan_id')->setValueOptions($plans);

        $inputFilter = new CustomerInputFilter($plans);
        $form->setInputFilter($inputFilter);

        return $form;
    }
}