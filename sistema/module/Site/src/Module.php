<?php

namespace Site;

use Admin\Controller\AuthController;
use Admin\Controller\CustomerController;
use Admin\Controller\MovieController;
use Admin\Controller\PhysicalEvaluationController;
use Admin\Controller\PlanController;
use Admin\Controller\SignatureController;
use Admin\Controller\TrainingController;
use MainClass\MainController;
use Site\Controller\AccompanimentController;
use Site\Controller\Factory\AccompanimentControllerFactory;
use Site\Controller\Factory\IndexControllerFactory;
use Site\Controller\Factory\LoginControllerFactory;
use Site\Controller\Factory\MyAccountControllerFactory;
use Site\Controller\IndexController;
use Site\Controller\LoginController;
use Site\Controller\MyAccountController;
use Site\Form\Contact\ContactForm;
use Site\Form\Contact\Factory\ContactFormFactory;
use Site\Form\Customer\CustomerForm;
use Site\Form\Customer\Factory\CustomerFormFactory;
use Site\Form\Login\Factory\SignInFormFactory;
use Site\Form\Login\SignInForm;
use Site\Form\MyAccount\Factory\MyAccountFormFactory;
use Site\Form\MyAccount\MyAccountForm;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Session\Container;

class Module implements ConfigProviderInterface, ServiceProviderInterface, ControllerProviderInterface
{
    protected $_session;

    /**
     * ON BOOTSTRAP
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function ($e) {

            $route = $e->getRouteMatch();

            $role = MainController::ROLE_GUEST;
            $parents = array(MainController::ROLE_GUEST);

            $acl = new Acl();
            $acl->addRole(new Role(MainController::ROLE_GUEST))
                ->addRole(new Role(MainController::MODULE_ADMIN), $parents)
                ->addRole(new Role(MainController::MODULE_SITE), $parents);

            $this->_session = new Container();

            if (isset($this->_session->{MainController::MODULE_ADMIN}) &&
                !empty($this->_session->{MainController::MODULE_ADMIN})
            ) {
                $role = MainController::MODULE_ADMIN;
            } else {
                if (isset($this->_session->{MainController::MODULE_SITE}) &&
                    !empty($this->_session->{MainController::MODULE_SITE})
                ) {
                    $role = MainController::MODULE_SITE;
                }
            }

            $acl->addResource(new Resource(AuthController::class));
            $acl->addResource(new Resource(AccompanimentController::class));
            $acl->addResource(new Resource(CustomerController::class));
            $acl->addResource(new Resource(PlanController::class));
            $acl->addResource(new Resource(MovieController::class));
            $acl->addResource(new Resource(SignatureController::class));
            $acl->addResource(new Resource(PhysicalEvaluationController::class));
            $acl->addResource(new Resource(IndexController::class));
            $acl->addResource(new Resource(\Admin\Controller\IndexController::class));
            $acl->addResource(new Resource(LoginController::class));
            $acl->addResource(new Resource(TrainingController::class));
            $acl->addResource(new Resource(MyAccountController::class));

            /**
             * ADMIN
             */
            $acl->deny(MainController::MODULE_ADMIN, AccompanimentController::class);
            $acl->deny(MainController::MODULE_ADMIN, MyAccountController::class);

            $acl->allow(MainController::MODULE_ADMIN, \Admin\Controller\IndexController::class);
            $acl->allow(MainController::MODULE_ADMIN, CustomerController::class);
            $acl->allow(MainController::MODULE_ADMIN, PlanController::class);
            $acl->allow(MainController::MODULE_ADMIN, MovieController::class);
            $acl->allow(MainController::MODULE_ADMIN, SignatureController::class);
            $acl->allow(MainController::MODULE_ADMIN, PhysicalEvaluationController::class);
            $acl->allow(MainController::MODULE_ADMIN, TrainingController::class);

            /**
             * SITE
             */
            $acl->allow(MainController::MODULE_SITE, AccompanimentController::class);
            $acl->allow(MainController::MODULE_SITE, MyAccountController::class);
            $acl->deny(MainController::MODULE_SITE, \Admin\Controller\IndexController::class);
            $acl->deny(MainController::MODULE_SITE, CustomerController::class);
            $acl->deny(MainController::MODULE_SITE, PlanController::class);
            $acl->deny(MainController::MODULE_SITE, MovieController::class);
            $acl->deny(MainController::MODULE_SITE, SignatureController::class);
            $acl->deny(MainController::MODULE_SITE, PhysicalEvaluationController::class);
            $acl->deny(MainController::MODULE_SITE, TrainingController::class);

            /**
             * GUEST
             */
            $acl->allow(MainController::ROLE_GUEST, IndexController::class);
            $acl->allow(MainController::ROLE_GUEST, LoginController::class);
            $acl->allow(MainController::ROLE_GUEST, AuthController::class);

            $res = $acl->isAllowed($role, $route->getParam('controller', 'index'));
            if ($res == false) {

                if ($route->getParam('module') == MainController::MODULE_ADMIN) {
                    $url = $e->getRouter()->assemble(array('action' => 'login'), array('name' => 'admin/auth'));
                } else {
                    $url = $e->getRouter()->assemble(array('action' => 'login'), array('name' => 'auth'));
                }

                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
                exit;
            }

        }, 101);
    }

    public function getConfig()
    {
        return include __DIR__ . "/../config/module.config.php";
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                ContactForm::class => ContactFormFactory::class,
                SignInForm::class => SignInFormFactory::class,
                MyAccountForm::class => MyAccountFormFactory::class,
                CustomerForm::class => CustomerFormFactory::class,
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                IndexController::class => IndexControllerFactory::class,
                AccompanimentController::class => AccompanimentControllerFactory::class,
                LoginController::class => LoginControllerFactory::class,
                MyAccountController::class => MyAccountControllerFactory::class
            ]
        ];
    }

}