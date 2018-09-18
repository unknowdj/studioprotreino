<?php

namespace Site\Controller;

use Admin\Model\CustomerTable;
use MainClass\AdminException;
use MainClass\MainController;
use Site\Form\Login\SignInForm;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class LoginController
 * @package Site\Controller
 */
class LoginController extends MainController
{
    /**
     * @var SignInForm
     */
    private $formSignIn;
    /**
     * @var CustomerTable
     */
    private $customerTable;

    /**
     * LoginController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param SignInForm $signInForm
     * @param CustomerTable $customerTable
     */
    function __construct(AdapterInterface $dbAdapter,
                         PhpRenderer $phpRender,
                         SignInForm $signInForm,
                         CustomerTable $customerTable)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->formSignIn = $signInForm;
        $this->customerTable = $customerTable;
        $this->_sessionModule = self::MODULE_SITE;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return $this->_view;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function loginAction()
    {
        $this->formSignIn->setAttribute('method', 'post');
        $this->formSignIn->setAttribute('action', $this->url()->fromRoute('auth/login'));

        if ($this->isAjaxRequest()) {
            unset($this->_session->{self::MODULE_ADMIN});
            $this->initTransaction();
            try {
                $data = $this->getPost();
                $entity = $this->customerTable->findByUserForAutentication($data['user'], $data['password']);
                $this->_session->{self::MODULE_SITE} = [
                    'customer' => $entity
                ];
                $this->setFlashMessageSuccess($this->translate('Welcome to ') . $entity['name']);
                $data['redirectUrl'] = ($this->_error) ? '' : $this->url()->fromRoute('accompaniment');
                return $this->sendAjaxResponse($data);
            } catch (AdminException $e) {
                $this->processRollback($this->translate('Attention'), $e, 'warning');
            } catch (\Exception $e) {
                $this->processRollback($this->translate('Error'), $e, 'error');
            }
            return $this->sendAjaxResponse();
        }

        return $this->_view->setVariable('form', $this->formSignIn);
    }

    /**
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        unset($this->_session->{self::MODULE_SITE});
        return $this->redirect()->toRoute('auth/login');
    }

}