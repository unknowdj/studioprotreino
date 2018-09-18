<?php

namespace Site\Form\Login\Factory;

use Interop\Container\ContainerInterface;
use Site\Form\Login\InputFilter\SignInInputFilter;
use Site\Form\Login\SignInForm;


class SignInFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new SignInInputFilter();
        $form = new SignInForm($container);
        $form->setInputFilter($inputFilter);
        return $form;
    }
}