<?php

namespace Admin\Form\Auth;

use Interop\Container\ContainerInterface;
use MainClass\MainForm;
use Zend\Form\Element\Submit;

/**
 * Class LoginForm
 * @package Admin\Form\Login
 */
class LoginForm extends MainForm
{
    /**
     * LoginForm constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'login');

        $this->add(array(
            'name' => 'user',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Digite seu usuário',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Usuário',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'attributes' => array(
                'placeholder' => 'Digite sua senha',
            ),
            'options' => array(
                'label' => 'Senha',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => array(
                'value' => 'ENTRAR',
            ),
        ));
    }
}