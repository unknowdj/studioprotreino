<?php

namespace Site\Form\Contact;

use Interop\Container\ContainerInterface;
use MainClass\MainForm;

class ContactForm extends MainForm
{

    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'contact');

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Insira seu nome completo',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Nome*',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'phone',
            'attributes' => array(
                'placeholder' => '()',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Telefone para contato*',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'name' => 'service',
            'options' => array(
                'label' => 'Qual é seu objetivo? (pode escolher mais de um)',
                'value_options' => array(
                    'Hipertrofia' => 'Hipertrofia',
                    'Emagrecimento' => 'Emagrecimento',
                    'Condicionamento Físico' => 'Condicionamento Físico',
                    'Reabilitação' => 'Reabilitação',
                ),
            )
        ));

        $this->add(array(
            'name' => 'send',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'ENVIAR',
            ),
        ));
    }
}