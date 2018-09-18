<?php
namespace Admin\Form\Training;

use Admin\Form\Training\Fieldset\SerieFieldset;
use Interop\Container\ContainerInterface;
use MainClass\MainForm;
use Zend\Form\Element\Collection;
use Zend\Form\Element\File;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Hydrator\ClassMethods;

class TrainingForm extends MainForm
{
    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'training');

        $this->setHydrator(new ClassMethods(false));

        $this->add(array(
            'name' => 'title',
            'type' => Text::class,
            'attributes' => array(
                'data-validate' => 'required',
                'required' => 'required',
            ),
            'options' => array(
                'label' => $this->translate('Name'),
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'type' => Textarea::class,
            'attributes' => array(),
            'options' => array(
                'label' => $this->translate('Description'),
            ),
        ));

        $this->add(array(
            'name' => 'training_id',
            'type' => Select::class,
            'options' => array(
                'label' => $this->translate('Training Father'),
            ),
        ));

        $this->setActiveInput([
            'label' => $this->translate('Active')
        ]);

        $this->add(array(
            'type' => Collection::class,
            'name' => 'series',
            'options' => array(
                'label' => $this->translate('Series'),
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'template_placeholder' => '__placeholder__',
                'target_element' => array(
                    'type' => SerieFieldset::class,
                ),
            ),
        ));

        $this->setButtonActions();
    }
}