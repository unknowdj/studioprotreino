<?php

namespace Site\Controller\Factory;


use Admin\Model\CustomerTable;
use Interop\Container\ContainerInterface;
use Site\Controller\LoginController;
use Site\Form\Login\SignInForm;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class LoginControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $signInForm = $container->get(SignInForm::class);
        $customerTable = $container->get(CustomerTable::class);
        $phpRender = $container->get(PhpRenderer::class);
        return new LoginController($dbAdapter, $phpRender, $signInForm, $customerTable);
    }
}