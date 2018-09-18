<?php

namespace Admin\Controller;

use Admin\Form\PhysicalEvaluation\PhysicalEvaluationForm;
use Admin\Model\PhysicalEvaluation;
use Admin\Model\PhysicalEvaluationTable;
use MainClass\AdminException;
use MainClass\MainController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class PhysicalEvaluationController
 * @package Admin\Controller
 */
class PhysicalEvaluationController extends MainController
{
    /**
     * @var PhysicalEvaluationTable
     */
    public $physicalEvaluationTable;
    /**
     * @var PhysicalEvaluationForm
     */
    public $physicalEvaluationForm;

    /**
     * PhysicalEvaluationController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param PhysicalEvaluationTable $physicalEvaluationTable
     * @param PhysicalEvaluationForm $physicalEvaluationForm
     */
    function __construct(
        AdapterInterface $dbAdapter,
        PhpRenderer $phpRender,
        PhysicalEvaluationTable $physicalEvaluationTable,
        PhysicalEvaluationForm $physicalEvaluationForm)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->physicalEvaluationTable = $physicalEvaluationTable;
        $this->physicalEvaluationForm = $physicalEvaluationForm;

        $this->headTitle($this->translate('Physical Evaluation'));
    }

    /**
     * LIST
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $signatureId = $this->getParam('signatureId', null);
        $rows = $this->physicalEvaluationTable->fetchAllBySignatureId($signatureId);
        return $this->_view->setVariables([
            'rows' => $rows,
            'signatureId' => $signatureId
        ]);
    }

    /**
     * ADD
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $this->headTitle($this->translate('Add'));
        $this->setForm($this->physicalEvaluationForm,
            'admin/physical-evaluation/add',
            [
                'signatureId' => $this->getParam('signatureId'),
                'modal' => $this->getParam('modal')
            ],
            'Add');
        return $this->setActions(self::ACTION_CREATE);
    }

    /**
     * EDIT
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        $this->headTitle($this->translate('Edit'));
        $data = (array)$this->physicalEvaluationTable->findById($this->getId());
        $data['date'] = $this->formatDate($data['date']);
        $this->setForm($this->physicalEvaluationForm,
            'admin/physical-evaluation/edit',
            [
                'id' => $this->getId(),
                'modal' => $this->getParam('modal')
            ],
            'Edit',
            $data);
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
            $data['redirectUrl'] = ($this->_error) ? '' : $this->url()->fromRoute('admin/physical-evaluation');
            $data['fancyboxClose'] = self::ACTIVE;
            return $this->sendAjaxResponse($data);
        }
        return $this->_view->setTemplate('admin/physical-evaluation/form.phtml');
    }

    /**
     * PROCESS FORM
     */
    private function processForm()
    {
        $this->initTransaction();
        try {
            $this->setPost();
            $this->post['date'] = $this->formatDate($this->post['date']);
            $this->validForm();
            $this->savePhysicalEvaluation();
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
    private function savePhysicalEvaluation()
    {
        $physicalEvaluation = new PhysicalEvaluation();
        $physicalEvaluation->exchangeArray($this->physicalEvaluationForm->getData());
        if ($this->_action == self::ACTION_CREATE) {
            $signatureId = (int)$this->getParam('signatureId');
            if (empty($signatureId)) {
                throw new AdminException('Não informado a assinatura');
            }
            $physicalEvaluation->signature_id = $signatureId;
        } else {
            $result = $this->physicalEvaluationTable->findById($this->getId());
            $physicalEvaluation->signature_id = $result->signature_id;
        }
        return $this->physicalEvaluationTable->save($physicalEvaluation, $this->getId());
    }
}