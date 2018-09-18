<?php

namespace Admin\Controller\Factory;


use Admin\Controller\MovieController;
use Admin\Form\Movie\MovieForm;
use Admin\Model\MovieTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class MovieControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        $movieTable = $container->get(MovieTable::class);
        $movieForm = $container->get(MovieForm::class);
        return new MovieController($dbAdapter, $phpRender, $movieTable, $movieForm);
    }
}