<?php

namespace Admin\Form\Plan;

use Interop\Container\ContainerInterface;
use MainClass\MainForm;

/**
 * Class PlanForm
 * @package Admin\Form\Plan
 */
class PlanForm extends MainForm
{
    /**
     * PlanForm constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'plan');

        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Digite um título',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Título',
            ),
        ));

        $this->add(array(
            'name' => 'category_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Categoria',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'attributes' => array(
                'placeholder' => 'Digite uma descrição',
            ),
            'options' => array(
                'label' => 'Descrição',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'value',
            'attributes' => array(
                'placeholder' => '0,00',
                'data-mask' => 'currency',
            ),
            'options' => array(
                'label' => 'Valor',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
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