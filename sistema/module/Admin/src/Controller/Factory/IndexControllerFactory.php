<?php

namespace Admin\Controller\Factory;

use Admin\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class IndexControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        return new IndexController($dbAdapter, $phpRender);
    }
}