<?php

namespace Admin\Controller;

use Admin\Form\Training\TrainingForm;
use Admin\Model\Training;
use Admin\Model\TrainingTable;
use MainClass\MainController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class TrainingController
 * @package Admin\Controller
 */
class TrainingController extends MainController
{
    /**
     * @var AdapterInterface
     */
    public $dbAdapter;
    /**
     * @var TrainingTable
     */
    public $trainingTable;
    /**
     * @var TrainingForm
     */
    public $trainingForm;
    /**
     * @var PhpRenderer
     */
    public $phpRender;

    /**
     * TrainingController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param TrainingTable $trainingTable
     * @param TrainingForm $trainingForm
     */
    function __construct(
        AdapterInterface $dbAdapter,
        PhpRenderer $phpRender,
        TrainingTable $trainingTable,
        TrainingForm $trainingForm)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->trainingTable = $trainingTable;
        $this->trainingForm = $trainingForm;

        $this->headTitle($this->translate('Training'));
    }

    /**
     * LIST
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $rows = $this->trainingTable->fetchAll();
        return $this->_view->setVariable('rows', $rows);
    }

    /**
     * ADD
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $this->headTitle($this->translate('Add'));
        $this->trainingForm->get('training_id')->setValue($this->getId());
        $this->setForm($this->trainingForm, 'admin/training/add', 'add', 'Add');
        return $this->setActions(self::ACTION_CREATE);
    }

    /**
     * EDIT
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        $this->headTitle($this->translate('Edit'));
        $data = (array)$this->trainingTable->findById($this->getId());
        if (!empty($data['series'])) {
            $se = [];
            foreach (json_decode($data['series']) as $serie) {
                $se[] = (array)$serie;
            }
            $data['series'] = $se;
        }
        $this->setForm($this->trainingForm, 'admin/training/edit', ['id' => $this->getId()], 'Edit', $data);
        return $this->setActions(self::ACTION_UPDATE);
    }

    /**
     * SET ACTIONS
     * @param $action
     * @return \Zend\View\Model\JsonModel|\Zend\View\Model\ViewModel
     */
    private function setActions($action)
    {
        if ($this->isAjaxRequest()) {
            $this->_action = $action;
            $this->processForm();
            $data['redirectUrl'] = ($this->_error) ? '' : $this->url()->fromRoute('admin/training');
            return $this->sendAjaxResponse($data);
        }
        return $this->_view->setTemplate('admin/training/form.phtml');
    }

    /**
     * PROCESS FORM
     */
    private function processForm()
    {
        $this->initTransaction();
        try {
            $this->setPost();
            if (!$this->post->training_id) {
                unset($this->post->series);
            }
            $this->validForm();
            $this->saveTraining();
            $this->setFlashMessageSuccess();
            $this->transaction->commit();
        } catch (AdminException $e) {
            $this->processRollback($this->translate('Attention'), $e, 'warning');
        } catch (\Exception $e) {
            $this->processRollback($this->translate('Error'), $e, 'error');
        }
    }

    /**
     * SAVE CUISINE
     */
    private function saveTraining()
    {
        $training = new Training();
        $training->exchangeArray($this->trainingForm->getData());
        $training->series = json_encode($training->series);
        return $this->trainingTable->save($training, $this->getId());
    }
}