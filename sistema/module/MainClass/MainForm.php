<?php

namespace MainClass;

use Interop\Container\ContainerInterface;
use Zend\Form\Element\Button;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;


class MainForm extends Form
{
    protected $_translate;

    public function __construct(ContainerInterface $container, $nameForm = null)
    {
        parent::__construct($nameForm);

        /**
         * SET ATTR
         */
        $this->setAttribute('role', 'form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'validate');
        $this->setAttribute('data-send-form-ajax', 'sendForm');

        /**
         * Security for form
         */
        $this->add(new Csrf('security'));
    }

    /**
     * TRANSLATE
     * @param $str
     * @return string
     */
    public function translate($str)
    {
        return $str;
    }

    /**
     * GET BUTTON ACTIONS
     * @return Submit
     */
    public function setButtonActions()
    {
        /**
         * BTN SUBMIT
         */
        $btnSubmit = new Submit('submit', [
            'label' => 'Salvar',
        ]);
        $btnSubmit->setAttribute('class', 'btn btn-sm btn-success');
        $this->add($btnSubmit);
        /**
         * BTN CANCEL
         */
        $btnCancel = new Button('cancel', [
            'label' => $this->translate('Cancel'),
        ]);
        $btnCancel->setAttribute('class', 'btn btn-sm btn-flat btn-primary');
        $this->add($btnCancel);
    }

    /**
     * GET BUTTONS MODAL ACTION
     */
    public function setButtonModalActions()
    {
        /**
         * BTN SUBMIT
         */
        $btnSubmit = new Submit('submit', [
            'label' => $this->translate('Search'),
        ]);
        $btnSubmit->setAttribute('class', 'btn btn-info');
        $this->add($btnSubmit);
        /**
         * BTN CANCEL
         */
        $btnCancel = new Button('cancel', [
            'label' => $this->translate('Cancel'),
        ]);
        $btnCancel->setAttribute('class', 'btn btn-white');
        $this->add($btnCancel);
    }

    public function setSearchButtonActions()
    {
        /**
         * BTN SEARCH
         */
        $btnSubmit = new Submit('search', [
            'label' => $this->translate('Search'),
        ]);
        $btnSubmit->setAttribute('class', 'btn btn-sm btn-flat btn-secondary');
        $this->add($btnSubmit);
        /**
         * BTN CLOSE
         */
        $btnClose = new Button('close', [
            'label' => $this->translate('Close the screen'),
        ]);
        $btnClose->setAttribute('class', 'btn btn-sm btn-flat btn-primary');
        $this->add($btnClose);
    }

    /**
     * SET DATE RANGE INPUT
     * @param $params
     */
    protected function setDateRangeInput($params)
    {
        $this->add(array(
            'name' => $params['name'] ?? 'date_tange',
            'type' => Text::class,
            'attributes' => array(
                'data-placeholder' => $params['labelPlaceholder'],
                'class' => 'daterange',
                'data-format' => 'DD/MM/YYYY',
                'data-separator' => $this->translate('-'),
            ),
            'options' => array(
                'add-on-prepend' => '<i class="fa-calendar"></i>',
                'label' => $this->translate($params['label'])
            )
        ));
    }

    /**
     * SET ACTIVE INPUT
     * @param $params
     */
    protected function setActiveInput($params)
    {
        $this->add(array(
            'name' => $params['name'] ?? 'active',
            'type' => Select::class,
            'attributes' => array(
                'data-placeholder' => $params['labelPlaceholder'] ?? '',
                'data-validate' => 'required',
                'required' => 'required',
                'class' => 'select2'
            ),
            'options' => array(
                'label' => $this->translate($params['label']),
                'value_options' => array(
                    '1' => $this->translate('Yes'),
                    '0' => $this->translate('No')
                )
            ),
        ));
    }
}
