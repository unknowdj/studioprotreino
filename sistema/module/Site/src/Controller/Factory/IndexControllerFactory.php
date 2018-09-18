<?php

namespace Site\Controller\Factory;


use Admin\Model\CustomerTable;
use Admin\Model\PlanTable;
use Admin\Model\SignatureTable;
use Interop\Container\ContainerInterface;
use Site\Controller\IndexController;
use Site\Form\Contact\ContactForm;
use Site\Form\Customer\CustomerForm;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

class IndexControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $phpRender = $container->get(PhpRenderer::class);
        $planTable = $container->get(PlanTable::class);
        $customerTable = $container->get(CustomerTable::class);
        $signatureTable = $container->get(SignatureTable::class);
        $contactForm = $container->get(ContactForm::class);
        $customerForm = $container->get(CustomerForm::class);
        return new IndexController(
            $dbAdapter,
            $phpRender,
            $planTable,
            $customerTable,
            $signatureTable,
            $contactForm,
            $customerForm);
    }
}