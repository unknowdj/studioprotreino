<?php

namespace Admin\Form\Movie;

use Interop\Container\ContainerInterface;
use MainClass\MainForm;

/**
 * Class MovieForm
 * @package Admin\Form\Movie
 */
class MovieForm extends MainForm
{
    /**
     * MovieForm constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, 'movie');

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'title',
            'attributes' => array(
                'placeholder' => 'Digite o título',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Título',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'attributes' => array(
                'placeholder' => 'Digite uma descrição',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Descrição',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'embed',
            'attributes' => array(
                'placeholder' => 'Ex: https://www.youtube.com/watch?v=DWckKx5DXvA',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Código (Youtube)',
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