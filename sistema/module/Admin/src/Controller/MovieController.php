<?php

namespace Admin\Controller;

use Admin\Form\Movie\MovieForm;
use Admin\Model\Movie;
use Admin\Model\MovieTable;
use MainClass\MainController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class MovieController
 * @package Admin\Controller
 */
class MovieController extends MainController
{
    /**
     * @var MovieTable
     */
    public $movieTable;
    /**
     * @var MovieForm
     */
    public $movieForm;
    /**
     * @var PhpRenderer
     */
    public $phpRender;

    /**
     * MovieController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param MovieTable $movieTable
     * @param MovieForm $movieForm
     */
    function __construct(
        AdapterInterface $dbAdapter,
        PhpRenderer $phpRender,
        MovieTable $movieTable,
        MovieForm $movieForm)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->movieTable = $movieTable;
        $this->movieForm = $movieForm;

        $this->headTitle($this->translate('Movie'));
    }

    /**
     * LIST
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $rows = $this->movieTable->fetchAll();
        return $this->_view->setVariable('rows', $rows);
    }

    /**
     * ADD
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $this->headTitle($this->translate('Add'));
        $this->setForm($this->movieForm, 'admin/movie/add', 'add', 'Add');
        return $this->setActions(self::ACTION_CREATE);
    }

    /**
     * EDIT
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        $this->headTitle($this->translate('Edit'));
        $data = (array)$this->movieTable->findById($this->getId());
        $this->setForm($this->movieForm, 'admin/movie/edit', ['id' => $this->getId()], 'Edit', $data);
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
            $data['redirectUrl'] = ($this->_error) ? '' : $this->url()->fromRoute('admin/movie');
            return $this->sendAjaxResponse($data);
        }
        return $this->_view->setTemplate('admin/movie/form.phtml');
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
            $this->saveMovie();
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
    private function saveMovie()
    {
        $movie = new Movie();
        $movie->exchangeArray($this->movieForm->getData());
        return $this->movieTable->save($movie, $this->getId());
    }
}