<?php

namespace Admin\Model;

use MainClass\MainModel;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Class PhysicalEvaluationTable
 * @package Admin\Model
 */
class PhysicalEvaluationTable extends MainModel
{
    /**
     * PhysicalEvaluationTable constructor.
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return array|\Zend\Paginator\Paginator
     */
    public function fetchAllBySignatureId($signatureId)
    {
        $select = new Select();
        $select
            ->from(['e' => 'physical_evaluations'])
            ->join(['s' => 'signature'], 'e.signature_id = s.id', [])
            ->join(['c' => 'customers'], 's.customer_id = c.id', ['customer_name' => 'name'])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title'])
            ->where(['signature_id' => $signatureId])
            ->order(['e.date DESC']);
        return $this->fetchBySelect($select);
    }

    /**
     * @return array|\Zend\Paginator\Paginator
     */
    public function getPhysicalEvaluationForChart($signatureId, $userId)
    {
        $select = new Select();
        $select
            ->from(['e' => 'physical_evaluations'])
            ->join(['s' => 'signature'], 'e.signature_id = s.id', ['date_initial', 'date_end'])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title'])
            ->where(['s.customer_id' => $userId])
            ->where(['s.id' => $signatureId]);
        return $this->fetchBySelect($select);
    }

    /**
     * @return array|\Zend\Paginator\Paginator
     */
    public function get()
    {
        $select = new Select();
        $select
            ->from(['e' => 'physical_evaluations'])
            ->join(['s' => 'signature'], 'e.signature_id = s.id', [])
            ->join(['c' => 'customers'], 's.customer_id = c.id', ['customer_name' => 'name'])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title']);
        return $this->fetchBySelect($select);
    }

    /**
     * SAVE
     * @param PhysicalEvaluation $physicalEvaluation
     * @return mixed
     */
    public function save(PhysicalEvaluation $physicalEvaluation, $id)
    {
        return parent::saveData((int)$id, $physicalEvaluation);
    }
}