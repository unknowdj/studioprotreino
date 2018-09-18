<?php

namespace Admin\Form\Signature\Factory;

use Admin\Form\Signature\InputFilter\SignatureInputFilter;
use Admin\Form\Signature\SignatureForm;
use Admin\Model\CustomerTable;
use Admin\Model\MovieTable;
use Admin\Model\PlanTable;
use Admin\Model\TrainingTable;
use Interop\Container\ContainerInterface;
use MainClass\MainController;

class SignatureFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new SignatureInputFilter();
        $form = new SignatureForm($container);
        $form->setInputFilter($inputFilter);

        $planTable = $container->get(PlanTable::class);
        $plans = $planTable->fetchAll();
        $plans = MainController::getSelect($plans, ['id', 'title']);
        $form->get('plan_id')->setValueOptions($plans);

        $customerTable = $container->get(CustomerTable::class);
        $customers = $customerTable->fetchAll()->toArray();
        $customers = MainController::getSelect($customers, ['id', 'name']);
        $form->get('customer_id')->setValueOptions($customers);

        $movieTable = $container->get(MovieTable::class);
        $movies = $movieTable->fetchAll()->toArray();
        $movies = MainController::getSelect($movies, ['id', 'title'], false);
        $form->get('movie')->setValueOptions($movies);

        $trainingTable = $container->get(TrainingTable::class);
        $trainings = $trainingTable->getFathers();
        $trainings = MainController::getSelect($trainings, ['id', 'title'], false);
        $form->get('training')->setValueOptions($trainings);

        return $form;
    }
}