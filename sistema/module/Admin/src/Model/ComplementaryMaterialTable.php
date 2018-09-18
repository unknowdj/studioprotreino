<?php

namespace Admin\Model;

use MainClass\MainModel;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Class ComplementaryMaterialTable
 * @package Admin\Model
 */
class ComplementaryMaterialTable extends MainModel
{

    /**
     * ComplementaryMaterialTable constructor.
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * SAVE
     * @param ComplementaryMaterial $complementaryMaterialr
     * @return mixed
     */
    public function save(ComplementaryMaterial $complementaryMaterialr, $id)
    {
        return parent::saveData((int)$id, $complementaryMaterialr);
    }

    /**
     * @param $signatureId
     * @return mixed
     */
    public function fetchBySignatureId($signatureId)
    {
        $select = new Select();
        $select
            ->from($this->tableGateway->getTable())
            ->where(['signature_id' => $signatureId]);
        return $this->fetchBySelect($select);
    }

    /**
     * @param $signatureId
     * @return bool
     */
    public function clearBySignatureId($signatureId)
    {
        return self::deleteRegister(['signature_id' => $signatureId]);
    }
}