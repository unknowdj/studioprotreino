<?php

namespace Admin\Model;

use MainClass\MainModel;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Class SignatureTable
 * @package Admin\Model
 */
class SignatureTable extends MainModel
{
    /**
     * SignatureTable constructor.
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return array|\Zend\Paginator\Paginator
     */
    public function fetchAll()
    {
        $select = new Select();
        $select
            ->from(['s' => 'signature'])
            ->join(['c' => 'customers'], 's.customer_id = c.id', ['customer_name' => 'name'])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title']);
        return $this->fetchBySelect($select);
    }

    /**
     * @param null $customerId
     * @return array|\Zend\Paginator\Paginator
     */
    public function fetchAllByCustomerId($customerId = null)
    {
        $select = new Select();
        $select
            ->from(['s' => 'signature'])
            ->join(['c' => 'customers'], 's.customer_id = c.id', ['customer_name' => 'name'])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title']);
        if ($customerId) {
            $select->where(['s.customer_id' => $customerId]);
        }
        return $this->fetchBySelect($select);
    }

    /**
     * @param null $signatureId
     * @return array|\Zend\Paginator\Paginator
     */
    public function getSignature($signatureId = null)
    {
        $select = new Select();
        $select
            ->from(['s' => 'signature'])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title'])
            ->where(['s.id' => $signatureId]);
        return $this->resultSetForCurrent($this->execSQL($select));
    }

    /**
     * SAVE
     * @param Signature $signature
     * @return mixed
     */
    public function save(Signature $signature, $id)
    {
        return parent::saveData((int)$id, $signature);
    }
}