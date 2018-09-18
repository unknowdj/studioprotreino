<?php

namespace Admin\Controller;

use Admin\Form\Auth\LoginForm;
use Admin\Model\Auth;
use Admin\Model\AuthTable;
use Admin\Model\User;
use Admin\Model\UserTable;
use MainClass\MainController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class AuthController
 * @package Admin\Controller
 */
class AuthController extends MainController
{
    /**
     * @var AuthTable
     */
    public $userTable;
    /**
     * @var AuthForm
     */
    public $loginForm;
    /**
     * @var PhpRenderer
     */
    public $phpRender;

    /**
     * AuthController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param UserTable $userTable
     * @param LoginForm $loginForm
     */
    function __construct(
        AdapterInterface $dbAdapter,
        PhpRenderer $phpRender,
        UserTable $userTable,
        LoginForm $loginForm)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->userTable = $userTable;
        $this->loginForm = $loginForm;

        $this->headTitle($this->translate('Auth'));
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function loginAction()
    {
        $this->setForm($this->loginForm, 'admin/auth/login', []);
        if ($this->isAjaxRequest()) {
            unset($this->_session->{self::MODULE_SITE});
            $this->initTransaction();
            try {
                $this->setPost();
                $this->validForm();
                $data = $this->loginForm->getData();
                $entity = $this->userTable->findByUserForAutentication($data['user'], $data['password']);
                $this->_session->{self::MODULE_ADMIN} = [
                    'user' => $entity
                ];
                $this->setFlashMessageSuccess($this->translate('Welcome to ' . ' ') . $entity->name);
                $data['redirectUrl'] = ($this->_error) ? '' : $this->url()->fromRoute('admin');
                return $this->sendAjaxResponse($data);
            } catch (AdminException $e) {
                $this->processRollback($this->translate('Attention'), $e, 'warning');
            } catch (\Exception $e) {
                $this->processRollback($this->translate('Error'), $e, 'error');
            }
            return $this->sendAjaxResponse();
        }
        return $this->_view;
    }

    /**
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        unset($this->_session->{self::MODULE_ADMIN});
        return $this->redirect()->toRoute('admin/auth/login');
    }
}