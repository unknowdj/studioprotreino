<?php

namespace Admin\Controller;

use Admin\Form\Signature\SignatureForm;
use Admin\Model\ComplementaryMaterial;
use Admin\Model\ComplementaryMaterialTable;
use Admin\Model\Plan;
use Admin\Model\PlanTable;
use Admin\Model\Signature;
use Admin\Model\SignatureTable;
use MainClass\MainController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class SignatureController
 * @package Admin\Controller
 */
class SignatureController extends MainController
{
    /**
     * @var SignatureTable
     */
    public $signatureTable;
    /**
     * @var Plan
     */
    public $planTable;
    /**
     * @var SignatureForm
     */
    public $signatureForm;
    /**
     * @var ComplementaryMaterialTable
     */
    public $complementaryMaterialTable;

    /**
     * SignatureController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param SignatureTable $signatureTable
     * @param SignatureForm $signatureForm
     */
    function __construct(
        AdapterInterface $dbAdapter,
        PhpRenderer $phpRender,
        SignatureTable $signatureTable,
        PlanTable $planTable,
        ComplementaryMaterialTable $complementaryMaterialTable,
        SignatureForm $signatureForm)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->planTable = $planTable;
        $this->signatureTable = $signatureTable;
        $this->complementaryMaterialTable = $complementaryMaterialTable;

        $this->signatureForm = $signatureForm;

        $this->headTitle($this->translate('Signature'));
    }

    /**
     * LIST
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $customerId = $this->getParam('customerId', null);
        $rows = $this->signatureTable->fetchAllByCustomerId($customerId);
        return $this->_view->setVariables([
            'rows' => $rows,
            'customerId' => $customerId,
            'modal' => $this->getParam('modal', null)
        ]);
    }

    /**
     * ADD
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $this->headTitle($this->translate('Add'));

        $customerId = $this->getParam('customerId');
        if ($customerId) {
            $this->signatureForm
                ->get('customer_id')
                ->setValue($customerId)
                ->setAttribute('readonly', 'readonly');
        }

        $this->setForm($this->signatureForm, 'admin/signature/add', [
            'customerId' => $customerId,
            'modal' => $this->getParam('modal')
        ], 'add');
        return $this->setActions(self::ACTION_CREATE);
    }

    /**
     * EDIT
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        $this->headTitle($this->translate('Edit'));
        $data = (array)$this->signatureTable->findById($this->getId());
        $data['date_range'] = self::formatDate($data['date_initial']) . ' ' . strtolower($this->translate('at')) . ' ' . self::formatDate($data['date_end']);

        $res = [];
        $cMaterials = $this->complementaryMaterialTable->fetchBySignatureId($data['id']);
        foreach ($cMaterials as $cMaterial) {
            if ($cMaterial['movie_id'])
                $res['movie'][] = $cMaterial['movie_id'];
            else if ($cMaterial['training_id'])
                $res['training'][] = $cMaterial['training_id'];
        }
        $this->signatureForm->get('movie')->setValue($res['movie']);
        $this->signatureForm->get('training')->setValue($res['training']);

        $this->setForm($this->signatureForm, 'admin/signature/edit', [
            'id' => $this->getId(),
            'modal' => $this->getParam('modal')
        ], 'Edit', $data);
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
            $data['redirectUrl'] = ($this->_error) ? '' : $this->url()->fromRoute('admin/signature');
            if ($this->getParam('modal')) {
                $data['fancyboxClose'] = self::ACTIVE;
            }
            return $this->sendAjaxResponse($data);
        }
        return $this->_view->setTemplate('admin/signature/form.phtml');
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
            $this->saveSignature();
            $this->setFlashMessageSuccess();
            $this->transaction->commit();
        } catch (AdminException $e) {
            $this->processRollback($this->translate('Attention'), $e, 'warning');
        } catch (\Exception $e) {
            $this->processRollback($this->translate('Error'), $e, 'error');
        }
    }

    /**
     * SAVE SIGNATURE
     */
    private function saveSignature()
    {
        $signature = new Signature();
        $signature->exchangeArray($this->signatureForm->getData());
        $dates = $this->prepareDateRange($this->post['date_range']);
        $signature->date_initial = $dates['start'];
        $signature->date_end = $dates['end'];

        if ($this->_action == self::ACTION_CREATE) {
            $plan = $this->planTable->findById($signature->plan_id);

            $signature->value = $plan->value;
        }
        $signatureId = $this->signatureTable->save($signature, $this->getId());

        $this->complementaryMaterialTable->clearBySignatureId($signatureId);

        foreach ($this->post['movie'] as $movieId) {
            $cMaterial = new ComplementaryMaterial();
            $cMaterial->signature_id = $signatureId;
            $cMaterial->movie_id = $movieId;
            $this->complementaryMaterialTable->save($cMaterial, null);
        }

        foreach ($this->post['training'] as $trainingId) {
            $cMaterial = new ComplementaryMaterial();
            $cMaterial->signature_id = $signatureId;
            $cMaterial->training_id = $trainingId;
            $this->complementaryMaterialTable->save($cMaterial, null);
        }
    }
}
