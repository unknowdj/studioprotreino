<?php

namespace Admin\Form\Movie\Factory;

use Interop\Container\ContainerInterface;
use Admin\Form\Movie\InputFilter\MovieInputFilter;
use Admin\Form\Movie\MovieForm;

class MovieFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new MovieInputFilter();
        $form = new MovieForm($container);
        $form->setInputFilter($inputFilter);
        return $form;
    }
}