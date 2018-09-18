<?php

namespace Admin\Form\Signature;

use Interop\Container\ContainerInterface;
use MainClass\MainForm;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;

/**
 * Class SignatureForm
 * @package Admin\Form\Signature
 */
class SignatureForm extends MainForm
{
    /**
     * SignatureForm constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'signature');

        $this->add(array(
            'name' => 'plan_id',
            'type' => Select::class,
            'attributes' => array(
                'required' => 'required',
                'class' => 'select2',
            ),
            'options' => array(
                'label' => 'Plano',
            ),
        ));

        $this->add(array(
            'name' => 'customer_id',
            'type' => Select::class,
            'attributes' => array(
                'required' => 'required',
                'class' => 'select2',
            ),
            'options' => array(
                'label' => 'Cliente',
            ),
        ));

        $this->add(array(
            'type' => Text::class,
            'name' => 'date_range',
            'attributes' => array(
                'required' => 'required',
                'data-format' => 'DD/MM/YYYY',
                'data-separator' => ' até ',
                'class' => 'daterange',
            ),
            'options' => array(
                'label' => 'Período',
            ),
        ));

        $this->add(array(
            'type' => MultiCheckbox::class,
            'name' => 'movie',
            'options' => array(
                'label' => 'Vídeos',
            ),
        ));

        $this->add(array(
            'type' => MultiCheckbox::class,
            'name' => 'training',
            'options' => array(
                'label' => 'Treinos',
            ),
        ));

        $this->add(array(
            'type' => Select::class,
            'name' => 'active',
            'attributes' => array(
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Ativo*',
                'value_options' => array(
                    '0' => 'Não',
                    '1' => 'Sim'
                ),
            ),
        ));

        $this->setButtonActions();
    }
}