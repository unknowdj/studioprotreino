<?php

namespace Admin\Form\Customer\Factory;

use Interop\Container\ContainerInterface;
use Admin\Form\Customer\InputFilter\CustomerInputFilter;
use Admin\Form\Customer\CustomerForm;

class CustomerFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new CustomerInputFilter();
        $form = new CustomerForm($container);
        $form->setInputFilter($inputFilter);
        return $form;
    }
}