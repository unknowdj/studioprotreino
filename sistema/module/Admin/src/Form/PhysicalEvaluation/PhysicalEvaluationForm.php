<?php

namespace Admin\Form\PhysicalEvaluation;

use Interop\Container\ContainerInterface;
use MainClass\MainForm;

/**
 * Class PhysicalEvaluationForm
 * @package Admin\Form\PhysicalEvaluation
 */
class PhysicalEvaluationForm extends MainForm
{
    /**
     * PhysicalEvaluationForm constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'physical-evaluation');

        $this->add(array(
            'name' => 'date',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'datepicker',
                'data-format' => 'dd/MM/yyyy',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Data',
            ),
        ));

        $this->add(array(
            'name' => 'weight',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Digite o peso atual',
                'required' => 'required',
                'data-mask' => 'unit_measurement'
            ),
            'options' => array(
                'label' => 'Peso',
            ),
        ));

        $this->add(array(
            'name' => 'fat_porcentage',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => '0%',
                'required' => 'required',
                'data-mask' => 'percent'
            ),
            'options' => array(
                'label' => '% de gordura',
            ),
        ));

        $this->add(array(
            'name' => 'muscle_mass_porcentage',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => '0%',
                'required' => 'required',
                'data-mask' => 'percent'
            ),
            'options' => array(
                'label' => '% de massa musc',
            ),
        ));

        $this->setButtonActions();
    }
}