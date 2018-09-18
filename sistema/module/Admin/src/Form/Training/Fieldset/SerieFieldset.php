<?php
namespace Admin\Form\Training\Fieldset;

use Admin\Form\Training\Entity\SerieEntity;
use Zend\Form\Element\Select;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

class SerieFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('series');

        $this
            ->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new SerieEntity());

        $this->setLabel('Phase');

        $res = [];
        foreach (range(1, 20) as $num) {
            $res[$num] = $num;
        }

        $this->add(array(
            'name' => 'phase',
            'type' => Select::class,
            'options' => array(
                'label' => 'Phase',
                'value_options' => $res
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $res = [];
        foreach (range(1, 4) as $num) {
            $res[$num] = $num;
        }

        $this->add(array(
            'name' => 'week',
            'type' => Select::class,
            'options' => array(
                'label' => 'Week',
                'value_options' => $res
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name' => 'charge',
            'options' => array(
                'label' => 'Charge',
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name' => 'repetition',
            'options' => array(
                'label' => 'Repetition',
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'phase' => array(
                'required' => true,
            ),
            'week' => array(
                'required' => true,
            ),
            'charge' => array(
                'required' => true,
            ),
            'repetition' => array(
                'required' => true,
            ),
        );
    }
}