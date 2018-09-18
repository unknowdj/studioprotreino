<?php

namespace Site\Form\MyAccount\Factory;

use Interop\Container\ContainerInterface;
use Site\Form\MyAccount\InputFilter\MyAccountInputFilter;
use Site\Form\MyAccount\MyAccountForm;

class MyAccountFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new MyAccountInputFilter();
        $form = new MyAccountForm($container);
        $form->setInputFilter($inputFilter);
        return $form;
    }
}