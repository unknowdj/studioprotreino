<?php

namespace Site\Controller\Factory;


use Admin\Model\CustomerTable;
use Admin\Model\MovieTable;
use Admin\Model\PhysicalEvaluationTable;
use Admin\Model\SignatureTable;
use Admin\Model\TrainingTable;
use Interop\Container\ContainerInterface;
use Site\Controller\AccompanimentController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class AccompanimentControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        $customerTable = $container->get(CustomerTable::class);
        $physicalEvaluationTable = $container->get(PhysicalEvaluationTable::class);
        $movieTable = $container->get(MovieTable::class);
        $trainingTable = $container->get(TrainingTable::class);
        $sigantureTable = $container->get(SignatureTable::class);
        return new AccompanimentController(
            $dbAdapter,
            $phpRender,
            $physicalEvaluationTable,
            $movieTable,
            $trainingTable,
            $sigantureTable,
            $customerTable);
    }
}