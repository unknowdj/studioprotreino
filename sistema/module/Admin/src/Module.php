<?php

namespace Admin;

use Admin\Controller\AuthController;
use Admin\Controller\ComplementaryMaterialController;
use Admin\Controller\CustomerController;
use Admin\Controller\Factory\AuthControllerFactory;
use Admin\Controller\Factory\ComplementaryMaterialControllerFactory;
use Admin\Controller\Factory\CustomerControllerFactory;
use Admin\Controller\Factory\IndexControllerFactory;
use Admin\Controller\Factory\MovieControllerFactory;
use Admin\Controller\Factory\PhysicalEvaluationControllerFactory;
use Admin\Controller\Factory\PlanControllerFactory;
use Admin\Controller\Factory\SignatureControllerFactory;
use Admin\Controller\Factory\TrainingControllerFactory;
use Admin\Controller\IndexController;
use Admin\Controller\MovieController;
use Admin\Controller\PhysicalEvaluationController;
use Admin\Controller\PlanController;
use Admin\Controller\SignatureController;
use Admin\Controller\TrainingController;
use Admin\Form\Auth\Factory\LoginFormFactory;
use Admin\Form\Auth\LoginForm;
use Admin\Form\Customer\CustomerForm;
use Admin\Form\Customer\Factory\CustomerFormFactory;
use Admin\Form\Movie\Factory\MovieFormFactory;
use Admin\Form\Movie\MovieForm;
use Admin\Form\PhysicalEvaluation\Factory\PhysicalEvaluationFormFactory;
use Admin\Form\PhysicalEvaluation\PhysicalEvaluationForm;
use Admin\Form\Plan\Factory\PlanFormFactory;
use Admin\Form\Plan\PlanForm;
use Admin\Form\Signature\Factory\SignatureFormFactory;
use Admin\Form\Signature\SignatureForm;
use Admin\Form\Training\Factory\TrainingFormFactory;
use Admin\Form\Training\TrainingForm;
use Admin\Helper\DateFormatHelper;
use Admin\Helper\FormatMoneyHelper;
use Admin\Helper\ItemListFormCollectionHelper;
use Admin\Helper\RecursiveTrainingGridHelper;
use Admin\Helper\StatusActiveHelper;
use Admin\Model\Factory\ComplementaryMaterialTableFactory;
use Admin\Model\Factory\ComplementaryMaterialTableGatewayFactory;
use Admin\Model\Factory\CustomerTableFactory;
use Admin\Model\Factory\CustomerTableGatewayFactory;
use Admin\Model\Factory\MovieTableFactory;
use Admin\Model\Factory\MovieTableGatewayFactory;
use Admin\Model\Factory\PhysicalEvaluationTableFactory;
use Admin\Model\Factory\PhysicalEvaluationTableGatewayFactory;
use Admin\Model\Factory\PlanTableFactory;
use Admin\Model\Factory\PlanTableGatewayFactory;
use Admin\Model\Factory\SignatureTableFactory;
use Admin\Model\Factory\SignatureTableGatewayFactory;
use Admin\Model\Factory\TrainingTableFactory;
use Admin\Model\Factory\TrainingTableGatewayFactory;
use Admin\Model\Factory\UserTableFactory;
use Admin\Model\Factory\UserTableGatewayFactory;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Class Module
 * @package Admin
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface, ControllerProviderInterface
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . "/../config/module.config.php";
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                PlanForm::class => PlanFormFactory::class,
                Model\PlanTable::class => PlanTableFactory::class,
                Model\PlanTableGateway::class => PlanTableGatewayFactory::class,

                CustomerForm::class => CustomerFormFactory::class,
                Model\CustomerTable::class => CustomerTableFactory::class,
                Model\CustomerTableGateway::class => CustomerTableGatewayFactory::class,

                MovieForm::class => MovieFormFactory::class,
                Model\MovieTable::class => MovieTableFactory::class,
                Model\MovieTableGateway::class => MovieTableGatewayFactory::class,

                SignatureForm::class => SignatureFormFactory::class,
                Model\SignatureTable::class => SignatureTableFactory::class,
                Model\SignatureTableGateway::class => SignatureTableGatewayFactory::class,

                PhysicalEvaluationForm::class => PhysicalEvaluationFormFactory::class,
                Model\PhysicalEvaluationTable::class => PhysicalEvaluationTableFactory::class,
                Model\PhysicalEvaluationTableGateway::class => PhysicalEvaluationTableGatewayFactory::class,

                LoginForm::class => LoginFormFactory::class,

                Model\UserTable::class => UserTableFactory::class,
                Model\UserTableGateway::class => UserTableGatewayFactory::class,

                Model\ComplementaryMaterialTable::class => ComplementaryMaterialTableFactory::class,
                Model\ComplementaryMaterialTableGateway::class => ComplementaryMaterialTableGatewayFactory::class,

                TrainingForm::class => TrainingFormFactory::class,
                Model\TrainingTable::class => TrainingTableFactory::class,
                Model\TrainingTableGateway::class => TrainingTableGatewayFactory::class,
            ]
        ];
    }

    /**
     * @return array
     */
    public function getControllerConfig()
    {
        return [
            'factories' => [
                IndexController::class => IndexControllerFactory::class,
                AuthController::class => AuthControllerFactory::class,
                PlanController::class => PlanControllerFactory::class,
                CustomerController::class => CustomerControllerFactory::class,
                MovieController::class => MovieControllerFactory::class,
                SignatureController::class => SignatureControllerFactory::class,
                PhysicalEvaluationController::class => PhysicalEvaluationControllerFactory::class,
                TrainingController::class => TrainingControllerFactory::class,
            ]
        ];
    }

    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'DateFormatHelper' => function () {
                    return new DateFormatHelper();
                },
                'StatusActiveHelper' => function () {
                    return new StatusActiveHelper();
                },
                'FormatMoneyHelper' => function () {
                    return new FormatMoneyHelper();
                },
                'RecursiveTrainingGridHelper' => function () {
                    return new RecursiveTrainingGridHelper();
                },
                'ItemListFormCollectionHelper' => function () {
                    return new ItemListFormCollectionHelper();
                },
            ],
        ];
    }

}