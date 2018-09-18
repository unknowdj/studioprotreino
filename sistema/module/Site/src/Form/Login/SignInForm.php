<?php

namespace Site\Form\Login;

use Interop\Container\ContainerInterface;
use MainClass\MainForm;

/**
 * Class SignInForm
 * @package Site\Form\Accompaniment
 */
class SignInForm extends MainForm
{
    /**
     * @var
     */
    protected $captcha;

    /**
     * SignInForm constructor.
     */
    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'accompaniment');

        $this->add(array(
            'name' => 'user',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Insira seu email',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'E-mail*',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'attributes' => array(
                'placeholder' => 'Insira sua senha',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Senha*',
            ),
        ));

        $this->add(array(
            'name' => 'send',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'ENTRAR',
            ),
        ));
    }
}