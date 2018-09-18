<?php

namespace Admin\Model\Factory;

use Admin\Model\PhysicalEvaluation;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class PhysicalEvaluationTableGatewayFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new PhysicalEvaluation());
        return new TableGateway('physical_evaluations', $dbAdapter, null, $resultSetPrototype);
    }


}