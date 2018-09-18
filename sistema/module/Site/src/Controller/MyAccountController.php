<?php

namespace Site\Controller;

use Admin\Model\Customer;
use Admin\Model\CustomerTable;
use MainClass\MainController;
use Site\Form\MyAccount\MyAccountForm;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class MyAccountController
 * @package Admin\Controller
 */
class MyAccountController extends MainController
{

    /**
     * @var CustomerTable
     */
    public $customerTable;
    /**
     * @var MyAccountForm
     */
    public $customerForm;

    /**
     * MyAccountController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param CustomerTable $customerTable
     * @param MyAccountForm $customerForm
     */
    function __construct(
        AdapterInterface $dbAdapter,
        PhpRenderer $phpRender,
        CustomerTable $customerTable,
        MyAccountForm $customerForm)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->customerTable = $customerTable;
        $this->customerForm = $customerForm;

        $this->headTitle($this->translate('My Account'));

        $this->_sessionModule = self::MODULE_SITE;
    }

    /**
     * My Account
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $data = (array)$this->customerTable->findById($this->getSiteUserId());
        $this->setForm($this->customerForm, 'accompaniment/my-account', [], $this->translate('Send'), $data);
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
            $data['redirectUrl'] = ($this->_error) ? '' : $this->url()->fromRoute('accompaniment/my-account');
            return $this->sendAjaxResponse($data);
        }
        return $this->_view->setTemplate('site/my-account/form.phtml');
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
                $entity = $this->customerTable->findById($this->getSiteUserId());
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
            $this->saveMyAccount();
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
    private function saveMyAccount()
    {
        $customer = new Customer();
        $customer->exchangeArray($this->customerForm->getData());
        $entity = $this->customerTable->findById($this->getSiteUserId());
        $customer->height = $entity->height;
        return $this->customerTable->save($customer, $this->getSiteUserId());
    }
}