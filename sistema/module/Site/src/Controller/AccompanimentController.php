<?php

namespace Site\Controller;

use Admin\Model\CustomerTable;
use Admin\Model\MovieTable;
use Admin\Model\PhysicalEvaluationTable;
use Admin\Model\Signature;
use Admin\Model\SignatureTable;
use Admin\Model\TrainingTable;
use MainClass\MainController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class AccompanimentController
 * @package Site\Controller
 */
class AccompanimentController extends MainController
{
    /**
     * @var CustomerTable
     */
    private $customerTable;
    /**
     * @var
     */
    private $physicalEvaluationTable;
    /**
     * @var MovieTable
     */
    private $movieTable;
    /**
     * @var TrainingTable
     */
    private $trainingTable;
    /**
     * @var Signature
     */
    private $sigantureTable;

    /**
     * AccompanimentController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param PhysicalEvaluationTable $physicalEvaluationTable
     * @param CustomerTable $customerTable
     */
    function __construct(AdapterInterface $dbAdapter,
                         PhpRenderer $phpRender,
                         PhysicalEvaluationTable $physicalEvaluationTable,
                         MovieTable $movieTable,
                         TrainingTable $trainingTable,
                         SignatureTable $sigantureTable,
                         CustomerTable $customerTable)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->customerTable = $customerTable;
        $this->movieTable = $movieTable;
        $this->trainingTable = $trainingTable;
        $this->sigantureTable = $sigantureTable;
        $this->physicalEvaluationTable = $physicalEvaluationTable;
        $this->_sessionModule = self::MODULE_SITE;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $signatureId = $this->getParam('signatureId');
        if ($signatureId) {
            $this->_session->{$this->_sessionModule}['customer']['signatureId'] = $signatureId;
            return $this->redirect()->toRoute('accompaniment/my-trainings');
        }

        $rows = $this->customerTable->getPlanActive($this->getSiteUserId());
        return $this->_view->setVariables([
            'rows' => $rows
        ]);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function myTrainingsAction()
    {
        $userId = $this->getSiteUserId();
        $signatureId = (int)$this->getSiteSignatureId();
        $siganture = $this->sigantureTable->getSignature($signatureId);
        $trainings = $this->trainingTable->getTariningActive($userId, $signatureId);
        return $this->_view->setVariables([
            'rows' => $trainings,
            'planDateInit' => self::formatDate($siganture['date_initial']),
            'planDateEnd' => self::formatDate($siganture['date_initial']),
            'planName' => $siganture['plan_name'],
        ]);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function chartAction()
    {
        $this->headScript->prependFile('https://www.gstatic.com/charts/loader.js');
        $rows = $this->physicalEvaluationTable->getPhysicalEvaluationForChart($this->getSiteSignatureId(), $this->getSiteUserId());
        return $this->_view->setVariables([
            'rows' => $rows
        ]);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function complementaryMaterialAction()
    {
        $userId = $this->getSiteUserId();
        $signatureId = (int)$this->getSiteSignatureId();
        $movies = $this->movieTable->getMoviesActive($userId, $signatureId);
        return $this->_view->setVariables([
            'rows' => $movies
        ]);
    }
}