<?php

namespace Site\Form\MyAccount;

use Interop\Container\ContainerInterface;
use MainClass\MainForm;

/**
 * Class MyAccountForm
 * @package Admin\Form\MyAccount
 */
class MyAccountForm extends MainForm
{
    /**
     * MyAccountForm constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'customer');

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => array(
                'placeholder' => 'Digite o nome',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Nome Completo',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'attributes' => array(
                'placeholder' => 'Digite um email',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'attributes' => array(
                'placeholder' => 'Digite a senha',
            ),
            'options' => array(
                'label' => 'Senha',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password_confirmation',
            'attributes' => array(
                'placeholder' => 'Redigite a senha',
            ),
            'options' => array(
                'label' => 'Redigite a senha',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'age',
            'attributes' => array(
                'placeholder' => 'Digite a idade',
                'required' => 'required',
                'data-mask' => 'int'
            ),
            'options' => array(
                'label' => 'Idade',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'ENVIAR',
            ),
        ));
    }
}