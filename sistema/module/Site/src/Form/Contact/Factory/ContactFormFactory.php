<?php

namespace Site\Form\Contact\Factory;

use Interop\Container\ContainerInterface;
use Site\Form\Contact\ContactForm;
use Site\Form\Contact\InputFilter\ContactInputFilter;

class ContactFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $form = new ContactForm($container);
        $inputFilter = new ContactInputFilter();
        $form->setInputFilter($inputFilter);
        return $form;
    }
}