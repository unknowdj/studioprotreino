<?php

namespace Admin\Controller\Factory;

use Admin\Controller\AuthController;
use Admin\Form\Auth\LoginForm;
use Admin\Model\UserTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class AuthControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        $userTable = $container->get(UserTable::class);
        $loginForm = $container->get(LoginForm::class);
        return new AuthController($dbAdapter, $phpRender, $userTable, $loginForm);
    }
}