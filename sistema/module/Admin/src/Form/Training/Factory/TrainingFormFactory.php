<?php

namespace Admin\Form\Training\Factory;

use Admin\Model\TrainingTable;
use Interop\Container\ContainerInterface;
use Admin\Form\Training\InputFilter\TrainingInputFilter;
use Admin\Form\Training\TrainingForm;
use MainClass\MainController;

class TrainingFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new TrainingInputFilter();
        $form = new TrainingForm($container);
        $form->setInputFilter($inputFilter);

        $trainingTable = $container->get(TrainingTable::class);
        $trainings = $trainingTable->getFathers();
        $trainings = MainController::getSelect($trainings, ['id', 'title']);

        $form->get('training_id')->setValueOptions($trainings);

        return $form;
    }
}