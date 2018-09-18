<?php

namespace Site\Controller\Factory;

use Admin\Model\CustomerTable;
use Interop\Container\ContainerInterface;
use Site\Controller\CustomerController;
use Site\Controller\MyAccountController;
use Site\Form\MyAccount\MyAccountForm;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class MyAccountControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        $customerTable = $container->get(CustomerTable::class);
        $myAccountForm = $container->get(MyAccountForm::class);
        return new MyAccountController($dbAdapter, $phpRender, $customerTable, $myAccountForm);
    }
}