<?php

namespace Admin\Model\Factory;

use Admin\Model\ComplementaryMaterial;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ComplementaryMaterialTableGatewayFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ComplementaryMaterial());
        return new TableGateway('complementary_material', $dbAdapter, null, $resultSetPrototype);
    }
}