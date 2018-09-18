<?php

namespace Admin\Controller\Factory;


use Admin\Controller\SignatureController;
use Admin\Form\Signature\SignatureForm;
use Admin\Model\ComplementaryMaterialTable;
use Admin\Model\PlanTable;
use Admin\Model\SignatureTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class SignatureControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        $signatureTable = $container->get(SignatureTable::class);
        $planTable = $container->get(PlanTable::class);
        $signatureForm = $container->get(SignatureForm::class);
        $complementaryMaterialTable = $container->get(ComplementaryMaterialTable::class);
        return new SignatureController($dbAdapter, $phpRender, $signatureTable, $planTable, $complementaryMaterialTable, $signatureForm);
    }
}