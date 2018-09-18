<?php

namespace Admin\Controller;

use Admin\Form\Customer\CustomerForm;
use Admin\Model\Customer;
use Admin\Model\CustomerTable;
use MainClass\MainController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class CustomerController
 * @package Admin\Controller
 */
class CustomerController extends MainController
{
    /**
     * @var CustomerTable
     */
    public $customerTable;
    /**
     * @var CustomerForm
     */
    public $customerForm;
    /**
     * @var PhpRenderer
     */
    public $phpRender;

    /**
     * CustomerController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param CustomerTable $customerTable
     * @param CustomerForm $customerForm
     */
    function __construct(
        AdapterInterface $dbAdapter,
        PhpRenderer $phpRender,
        CustomerTable $customerTable,
        CustomerForm $customerForm)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->customerTable = $customerTable;
        $this->customerForm = $customerForm;

        $this->headTitle($this->translate('Customer'));
    }

    /**
     * LIST
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $rows = $this->customerTable->fetchAll();
        return $this->_view->setVariable('rows', $rows);
    }

    /**
     * ADD
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $this->headTitle($this->translate('Add'));
        $this->setForm($this->customerForm, 'admin/customer/add', 'add', 'Add');
        return $this->setActions(self::ACTION_CREATE);
    }

    /**
     * EDIT
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        $this->headTitle($this->translate('Edit'));
        $data = (array)$this->customerTable->findById($this->getId());
        $this->setForm($this->customerForm, 'admin/customer/edit', ['id' => $this->getId()], 'Edit', $data);
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
            $data['redirectUrl'] = ($this->_error) ? '' : $this->url()->fromRoute('admin/customer');
            return $this->sendAjaxResponse($data);
        }
        return $this->_view->setTemplate('admin/customer/form.phtml');
    }

    /**
     * PROCESS FORM
     */
    private function processForm()
    {
        $this->initTransaction();
        try {
            $this->setPost();

            if ($this->_action == self::ACTION_UPDATE) {
                $entity = $this->customerTable->findById($this->getId());
                $updated = $this->customerTable->passwordWasUpdated($this->post);
                if (!$updated) {
                    $this->post->password = $entity->password;
                    $this->post->password_confirmation = $entity->password;
                }
            }

            if ($this->_action == self::ACTION_CREATE || $updated) {
                $cryptPassword = $this->customerTable->generatePassword($this->post->password);
                $this->post->password = $cryptPassword;
                $this->post->password_confirmation = $cryptPassword;
            }

            $this->validForm();
            $this->saveCustomer();
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
    private function saveCustomer()
    {
        $customer = new Customer();
        $customer->exchangeArray($this->customerForm->getData());
        return $this->customerTable->save($customer, $this->getId());
    }
}