<?php

namespace Admin\Controller;

use Admin\Form\Plan\PlanForm;
use Admin\Model\Plan;
use Admin\Model\PlanTable;
use MainClass\MainController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class PlanController
 * @package Admin\Controller
 */
class PlanController extends MainController
{
    /**
     * @var PlanTable
     */
    public $planTable;
    /**
     * @var PlanForm
     */
    public $planForm;
    /**
     * @var PhpRenderer
     */
    public $phpRender;

    /**
     * PlanController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param PlanTable $planTable
     * @param PlanForm $planForm
     */
    function __construct(
        AdapterInterface $dbAdapter,
        PhpRenderer $phpRender,
        PlanTable $planTable,
        PlanForm $planForm)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->planTable = $planTable;
        $this->planForm = $planForm;

        $this->headTitle($this->translate('Plan'));
    }

    /**
     * LIST
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $rows = $this->planTable->fetchAll();
        return $this->_view->setVariable('rows', $rows);
    }

    /**
     * ADD
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $this->headTitle($this->translate('Add'));
        $this->setForm($this->planForm, 'admin/plan/add', 'add', 'Add');
        return $this->setActions(self::ACTION_CREATE);
    }

    /**
     * EDIT
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        $this->headTitle($this->translate('Edit'));
        $data = (array)$this->planTable->findById($this->getId());
        $this->setForm($this->planForm, 'admin/plan/edit', ['id' => $this->getId()], 'Edit', $data);
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
            $data['redirectUrl'] = ($this->_error) ? '' : $this->url()->fromRoute('admin/plan');
            return $this->sendAjaxResponse($data);
        }
        return $this->_view->setTemplate('admin/plan/form.phtml');
    }

    /**
     * PROCESS FORM
     */
    private function processForm()
    {
        $this->initTransaction();
        try {
            $this->setPost();
            $this->validForm();
            $this->savePlan();
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
    private function savePlan()
    {
        $plan = new Plan();
        $plan->exchangeArray($this->planForm->getData());
        $plan->value = $this->getFloat($plan->value);
        return $this->planTable->save($plan, $this->getId());
    }
}