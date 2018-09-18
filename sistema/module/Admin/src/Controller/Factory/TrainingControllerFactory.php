<?php

namespace Admin\Controller\Factory;

use Admin\Controller\TrainingController;
use Admin\Form\Training\TrainingForm;
use Admin\Model\TrainingTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class TrainingControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $trainingTable = $container->get(TrainingTable::class);
        $trainingForm = $container->get(TrainingForm::class);
        $phpRender = $container->get(PhpRenderer::class);
        return new TrainingController($dbAdapter, $phpRender, $trainingTable, $trainingForm);
    }
}