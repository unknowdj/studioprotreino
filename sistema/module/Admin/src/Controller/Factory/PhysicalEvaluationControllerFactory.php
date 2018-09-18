<?php

namespace Admin\Controller\Factory;


use Admin\Controller\PhysicalEvaluationController;
use Admin\Form\PhysicalEvaluation\PhysicalEvaluationForm;
use Admin\Model\PhysicalEvaluationTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class PhysicalEvaluationControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        $physicalEvaluationTable = $container->get(PhysicalEvaluationTable::class);
        $physicalEvaluationForm = $container->get(PhysicalEvaluationForm::class);
        return new PhysicalEvaluationController($dbAdapter, $phpRender, $physicalEvaluationTable, $physicalEvaluationForm);
    }
}