<?php

namespace Site\Form\Customer;

use Interop\Container\ContainerInterface;
use MainClass\MainForm;

/**
 * Class CustomerForm
 * @package Admin\Form\Customer
 */
class CustomerForm extends MainForm
{
    /**
     * CustomerForm constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'customer');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'plan_id',
            'attributes' => array(
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Plano',
            ),
        ));

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
                'label' => 'Email (Usuário da área restrita)',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'attributes' => array(
                'placeholder' => 'Digite a senha',
                'required' => 'required',
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
                'required' => 'required',
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
            'type' => 'Zend\Form\Element\Text',
            'name' => 'height',
            'attributes' => array(
                'placeholder' => 'Digite o peso atual',
                'required' => 'required',
                'data-mask' => 'unit_measurement'
            ),
            'options' => array(
                'label' => 'Peso atual',
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