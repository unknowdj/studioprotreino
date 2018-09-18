<?php

namespace Admin\Form\Auth\Factory;

use Admin\Form\Auth\InputFilter\LoginInputFilter;
use Admin\Form\Auth\LoginForm;
use Interop\Container\ContainerInterface;

class LoginFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new LoginInputFilter();
        $form = new LoginForm($container);
        $form->setInputFilter($inputFilter);
        return $form;
    }
}