<?php

namespace Admin\Controller\Factory;


use Admin\Controller\PlanController;
use Admin\Form\Plan\PlanForm;
use Admin\Model\PlanTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class PlanControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        $planTable = $container->get(PlanTable::class);
        $planForm = $container->get(PlanForm::class);
        return new PlanController($dbAdapter, $phpRender, $planTable, $planForm);
    }
}