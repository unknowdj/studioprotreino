<?php

namespace Admin\Controller\Factory;


use Admin\Controller\CustomerController;
use Admin\Form\Customer\CustomerForm;
use Admin\Model\CustomerTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class CustomerControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        $customerTable = $container->get(CustomerTable::class);
        $customerForm = $container->get(CustomerForm::class);
        return new CustomerController($dbAdapter, $phpRender, $customerTable, $customerForm);
    }
}