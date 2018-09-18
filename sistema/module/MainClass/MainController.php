<?php

namespace MainClass;


use Zend\Db\Adapter\AdapterInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class MainController
 * @package MainClass
 */
class MainController extends AbstractActionController
{

    /**
     *
     */
    const SITE_NAME = 'PRO TREINO';

    /**
     *
     */
    const ACTIVE = 1;
    /**
     *
     */
    const NOT_ACTIVE = 0;

    /**
     *
     */
    const ROLE_GUEST = 'guest';

    /**
     *
     */
    const MODULE_SITE = 'SITE';

    /**
     *
     */
    const MODULE_ADMIN = 'ADMIN';

    /**
     *
     */
    const ACTION_CREATE = 'create';
    /**
     *
     */
    const ACTION_UPDATE = 'update';

    /**
     * @var
     */
    protected $post;
    /**
     * @var
     */
    protected $form;
    /**
     * @var
     */
    protected $transaction;
    /**
     * @var ViewModel
     */
    protected $_view;
    /**
     * @var JsonModel
     */
    protected $_json;
    /**
     * @var int
     */
    protected $_error = 0;
    /**
     * @var
     */
    protected $_redirectUrl;
    /**
     * @var array
     */
    protected $_orderFields = [];
    /**
     * @var array
     */
    protected $_orderFieldsDefault = [];
    /**
     * @var array
     */
    protected $_filtersFields = [];
    /**
     * @var
     */
    protected $_action;
    /**
     * @var
     */
    protected $_sessionModule;

    /**
     * MainController constructor.
     */
    public function __construct(AdapterInterface $dbAdapter, PhpRenderer $phpRender)
    {
        /**
         * VIEW
         */
        $this->_view = new ViewModel();
        /**
         * JSON VIEW
         */
        $this->_json = new JsonModel();
        /**
         * SESSION
         */
        $this->_session = new Container();
        /**
         * dbApter
         */
        $this->dbAdapter = $dbAdapter;
        /**
         * phpRender
         */
        $this->phpRender = $phpRender;
        /**
         * headScript
         */
        $this->headScript = $this->phpRender->headScript();
        /**
         * headLink
         */
        $this->headLink = $this->phpRender->headLink();
    }

    /**
     * SET EVENT MANAGER
     * @param EventManagerInterface $events
     */
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);
        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            /**
             * FLASH MESSAGE
             */
            $this->_view->setVariable('flashMessages', $this->flashMessenger()->getMessages());
            /**
             * MODAL LAYOUT
             */
            $this->isModalLayout();
            /**
             * is Logged
             */
            $this->layout()->isLogged = $this->isUserLogged();
            $this->_view->userName = $this->getUserName();
            $this->_view->signatureId = $this->getSiteSignatureId();
        }, 100);
    }

    /**
     * HEAD TITLE
     * @param $title
     */
    public function headTitle($title)
    {
        $this->phpRender->headTitle($title);
    }

    /**
     * BASE URL
     * @param $path
     * @return string
     */
    public function baseUrl($path)
    {
        $uri = $this->getRequest()->getUri();
        $baseUrl = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        return $baseUrl . $path;
    }

    /**
     * IS AJAX REQUEST
     * @param string $method
     * @return bool
     */
    public function isAjaxRequest($method = 'isPost')
    {
        if ($this->getRequest()->isXmlHttpRequest() && $this->getRequest()->{$method}()) {
            return true;
        }
        return false;
    }

    /**
     * IS MODAL LAYOUT
     * @return bool
     */
    public function isModalLayout()
    {
        if ($this->getParam('modal') == self::ACTIVE) {
            $this->layout('layout/modal');
            return true;
        }
        return false;
    }

    /**
     * SET POST
     */
    public function setPost()
    {
        $this->post = $this->getPost();
    }

    /**
     * GET POST
     * @return mixed
     */
    public function getPost()
    {
        return $this->getRequest()->getPost();
    }

    /**
     * GET ID
     * @param int $id
     * @return int]
     */
    public function getId($id = 0)
    {
        return (int)$this->getParam('id', $id);
    }

    /**
     * INIT TRANSACTION
     * @return mixed
     */
    public function initTransaction()
    {
        $this->transaction = $this->dbAdapter->getDriver()->getConnection();
        $this->transaction->beginTransaction();
        return $this->transaction;
    }

    /**
     * PROCESS ROLLBACK
     * @param $title
     * @param $exception
     * @param $messageType
     */
    public function processRollback($title, $exception, $messageType)
    {
        $this->_error = self::ACTIVE;
        if (isset($this->_transaction)) {
            $this->_transaction->rollback();
        }

        $this->addMessage([
            'title' => $title,
            'message' => $exception->getMessage(),
            'type' => $messageType
        ]);
    }

    /**
     * SET GROUP NAME
     * @param $name
     * @param string $description
     */
    public function setGroupName($name, $description = '')
    {
        /**
         * HEAD TITLE
         */
        if (!empty($name)) {
            $this->headTitle($name);
        }
        /**
         * GROUP NAME
         */
        $this->_view->setVariables([
            'moduleControllerTitle' => $name ?? $this->_view->moduleControllerTitle,
            'moduleControllerDescription' => $description
        ]);
    }

    /**
     * SEND AJA RESPONSE
     * @param null $data
     * @param int $error
     * @return JsonModel
     */
    public function sendAjaxResponse($data = null, $error = 0)
    {
        $this->_json->setVariable('error', ($error) ? $error : $this->_error);
        $this->_json->setVariable('flashMessages', $this->_view->getVariable('flashMessages'));
        if (!empty($data)) {
            $this->_json->setVariables($data);
        }
        return $this->_json;
    }

    /**
     * SET VARIOUS MESSAGES
     * @param type $message
     */
    public function addMessage($message)
    {
        $this->_view->setVariable('flashMessages', array_merge([$message], $this->_view->getVariable('flashMessages')));
    }

    /**
     * SET FLASH MESSAGE SUCCESS
     * @param null $message
     */
    protected function setFlashMessageSuccess($message = null)
    {
        $this->addMessage([
            'title' => $this->translate('Success!'),
            'message' => $message ?? $this->translate('The data were saved'),
            'type' => 'success'
        ]);
    }

    /**
     * TRANSLATE
     * @param $str
     * @return mixed
     */
    public function translate($str)
    {
        return $this->phpRender->translate($str);
    }

    /**
     * SET FORM
     * @param $form
     * @param $route
     * @param $params
     * @param null $labelSubmit
     * @param null $data
     * @param bool $setForm
     */
    protected function setForm($form, $route, $params, $labelSubmit = null, $data = null, $setForm = true)
    {
        if (!is_array($params)) {
            $params = ['action' => $params];
        }
        $this->_form = $form;
        $this->_form->setAttribute('action', $this->url()->fromRoute($route, $params));
        /**
         * LABEL SUBMIT
         */
        if (!empty($labelSubmit)) {
            $this->_form->get('submit')->setAttribute('value', $this->translate($labelSubmit));
        }
        /**
         * SET DATA
         */
        if (!empty($data)) {
            $this->_form->setData($data);
        }
        /**
         * SET FORM
         */
        if ($setForm) {
            $this->_view->setVariable('form', $this->_form);
        }
    }

    /**
     * VALID FORM
     * @throws AdminException
     */
    protected function validForm()
    {
        if (!isset($this->_form)) {
            throw new AdminException($this->translate('Form was not set'));
        }

        if (!isset($this->post)) {
            throw new AdminException($this->translate('Post was not set'));
        }

        $this->_form->setData($this->post);
        if (!$this->_form->isValid()) {
            $this->_json->setVariable('formError', $this->_form->getMessages());
            throw new AdminException($this->translate('Invalid data'));
        }
        /**
         * SET DATA VALIDATED
         */
        if ($this->getRequest()->isPost() || $this->isAjaxRequest()) {
            $this->post = $this->_form->getData();
        }
    }

    /**
     * VALID FORM COLLECTION
     * @throws AdminException
     */
    protected function validFormCollection()
    {
        if (!isset($this->_form)) {
            throw new AdminException($this->translate('Form was not set'));
        }

        if (!isset($this->post)) {
            throw new AdminException($this->translate('Post was not set'));
        }

        $this->_form->setData($this->post);
        if (!$this->_form->isValid()) {
            $this->_json->setVariable('formError', $this->_form->getMessages());
            throw new AdminException($this->translate('Invalid data'));
        }
        /**
         * SET DATA VALIDATED
         */
        if ($this->getRequest()->isPost() || $this->isAjaxRequest()) {
            $this->post = $this->_form->getData();
        }
    }

    /**
     * GET PARAM
     * @param string $param
     * @param string $default
     * @return string
     */
    public function getParam($param, $default = null)
    {
        $res = $this->params()->fromQuery($param, $default);
        $res = $this->params()->fromPost($param, $res);
        return $this->params()->fromRoute($param, $res);
    }

    /**
     * DEBUG
     * @param $var
     * @param bool $exit
     */
    static public function debug($var, $exit = true)
    {
        echo '<pre>';
        echo 'Inicio debug <br><br>';
        print_r($var);
        echo '<br>Fim debug <br>';
        echo '</pre>';
        $exit == true ? exit : '';
    }

    /**
     * DATE NOW
     * @param string $format
     * @return false|string
     */
    public function dateNow($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    /**
     * @param $num
     * @param bool $change
     * @param int $decimals
     * @return float|mixed|string
     */
    function getFloat($num, $change = true, $decimals = 2)
    {
        if (is_float($num)) {
            return $num;
        } else {
            if ($change) {
                $num = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $num);
                return (float)number_format((float)$num, $decimals, '.', '');
            } else {
                return sprintf('%.2f', $num);
            }
        }
    }

    /**
     * @param $num
     * @param bool $change
     * @param int $decimals
     * @return float|mixed|string
     */
    static function formatMoneyDb($num, $change = true, $decimals = 4)
    {
        if (is_float($num)) {
            return $num;
        } else {
            if ($change) {
                $num = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $num);
                return (float)number_format((float)$num, $decimals, '.', '');
            } else {
                return sprintf('%.2f', $num);
            }
        }
    }

    /**
     * @param $fileNameOld
     * @param $path
     * @param $field
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    public function processUploadFile($fileNameOld, $path, $field, $params)
    {
        $upload = new MainUpload();
        $upload->setFile($this->params()->fromFiles($field));
        $upload->setFileName($field);
        if ($upload->isUploaded()) {
            $upload->remameFile($params['rename']);
            $upload->setUploadPath($path);
            $res = $upload->processUpload();
            $upload->destroyFile($fileNameOld);
            if ($res['success'] == true) {
                return $res['file_name'];
            } else {
                throw new \Exception($res['error_messages']);
            }
        } else {
            return $fileNameOld;
        }
    }

    /**
     * @param array $obj
     * @param array $field
     * @param bool $sel
     * @return array
     */
    static function getSelect($obj = [], $field = ['id', 'title'], $sel = true)
    {
        $res = [];
        if ($sel) {
            $res[''] = 'Selecione';
        }
        foreach ($obj as $row):
            $res[$row[$field[0]]] = self::getStringForSelectOption($field[1], $row);
        endforeach;
        return $res;
    }

    /**
     * @param $field
     * @param $row
     * @return mixed|string
     */
    static function getStringForSelectOption($field, $row)
    {
        if (is_array($field)) {
            $a = [];
            foreach ($field as $f) {
                $a[] = $row[$f];
            }
            $str = implode(' - ', $a);
        } else {
            $str = $row[$field];
        }
        return mb_strtoupper($str, 'UTF-8');
    }

    /**
     * @param $dateRange
     * @return array
     */
    static public function prepareDateRange($dateRange)
    {
        return [
            'start' => self::formatDate(substr(trim($dateRange), 0, 10)),
            'end' => self::formatDate(substr(trim($dateRange), 16)),
        ];
    }

    /**
     * @param $dateStr
     * @param string $separator
     * @return mixed
     * @throws \Exception
     */
    static public function formatDate($dateStr, $time = 0, $separator = ' - ')
    {

        if (empty($dateStr)) {
            throw new \Exception('Date empty');
        }

        $format = 'd/m/Y';

        $date = substr($dateStr, 0, 10);
        if (strpos($date, '/')) {
            $format = 'Y-m-d';
            $dateArray = explode('/', $date);
            $dateStr = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        }

        if (strlen($dateStr) > 10 && $time == true) {
            $format .= $separator . 'H:m';
            $dateStr .= substr($dateStr, 11, 5);
        }
        $date = date_create($dateStr);
        return date_format($date, $format);
    }

    /**
     * @return bool
     */
    public function isUserLogged()
    {
        return (isset($this->_session->{$this->_sessionModule}) && !empty($this->_session->{$this->_sessionModule}));
    }

    /**
     * @return bool
     */
    public function getUserName()
    {
        if ($this->isUserLogged()) {
            return $this->_session->{$this->_sessionModule}['customer']['name'];
        }
        return null;
    }

    /**
     * @return mixed
     * @throws AdminException
     */
    public function getSiteUserId()
    {
        $session = $this->_session->{$this->_sessionModule};
        if (!isset($session['customer']) || !isset($session['customer']['id'])) {
            throw new AdminException($this->translate('User id not found.'));
        }
        return $session['customer']['id'];
    }

    /**
     * @return mixed
     * @throws AdminException
     */
    public function getSiteSignatureId()
    {
        if ($this->isUserLogged()) {
            $session = $this->_session->{$this->_sessionModule};
            return $session['customer']['signatureId'] ?? null;
        }
    }
}

/**
 * Class AdminException
 * @package Admin\Controller
 */
class AdminException extends \Exception
{

}