<?php
/**
 * Project: O que fazer culinária
 * ==================================
 * Dev: Rafael Silva
 * Email: contato@pantoneweb.com.br
 * Phone: +55 14 9-9747-2101
 * ==================================
 */

namespace MainClass;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

/**
 * Class MainModel
 * @package MainClass
 */
class MainModel
{

    protected $virifyUniqueResult = MainController::ACTIVE;

    /**
     * @var TableGatewayInterface
     */
    protected $tableGateway;

    /**
     * FETCH ALL
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * FIND BY ID
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        return $this->resultSetForCurrent($rowset);
    }

    /**
     * SAVE
     * @param $id
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    protected function saveData($id, $data)
    {
        $data = $this->setDateTime($data);
        $arrData = $data->toArray();
        $arrData = $this->clearEmptyArrayKey($arrData);
        /**
         * CREATE
         */
        if (empty($id)) {
            unset($arrData['id']);

            if ($this->tableGateway->insert($arrData)) {
                return $this->tableGateway->lastInsertValue;
            } else {
                throw new \Exception('Error saving record.');
            }
        }


        /**
         * UPDATE
         */
        if (!empty($id)) {
            $this->findById($id);
            $this->tableGateway->update($arrData, ['id' => $id]);
            return $id;
        }

        throw new \Exception('Error saving record.');
    }

    /**
     * @param Select $select
     * @param bool $paginated
     * @return array|Paginator
     */
    public function fetchBySelect(Select $select, $paginated = false)
    {
        if ($paginated) {
            return $this->execPaginatorSQL($select);
        }
        return $this->resultSetForArray($this->execSQL($select));
    }

    /**
     *
     * @param PreparableSqlInterface $select
     * @return Paginator
     */
    public function execPaginatorSQL($select)
    {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->buffer();
        $paginatorAdapter = new DbSelect($select, $this->tableGateway->getAdapter(), $resultSetPrototype);
        return new Paginator($paginatorAdapter);;
    }

    /**
     * @param $select
     * @param bool $debug
     * @return mixed
     */
    public function execSQL($select, $debug = false)
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        if ($debug == true) {
            echo '<pre>';
            echo $select->getSqlString($adapter->getPlatform());
            exit;
        }
        return $statement->execute();
    }

    /**
     * DELETE REGISTER
     * @param array $where
     * @return boolean
     */
    public function deleteRegister($where)
    {
        if ($this->tableGateway->delete($where)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function setDateTime($data)
    {
        if (property_exists($data, 'create_at') && (property_exists($data, 'id') && empty($data->id))) {
            $data->create_at = date('Y-m-d H:i:s');
        }
        if (property_exists($data, 'update_at')) {
            $data->update_at = date('Y-m-d H:i:s');
        }
        return $data;
    }

    /**
     * @param $data
     * @return array
     */
    protected function clearEmptyArrayKey($data)
    {
        $arr = [];
        foreach ($data as $key => $value) {
            if (($value === '0' || $value === 0 || $value === 'null') || !empty($value))
                $arr[$key] = $value;
        }
        return $arr;
    }

    /**
     * RESULT SER FOR ARRAY
     * @param array $results
     * @return array
     */
    protected function resultSetForArray($results)
    {
        $res = array();
        if (!empty($results) && count($results) > 0) {
            foreach ($results as $key => $result) {
                $res[$key] = $result;
            }
        }
        return $res;
    }

    /**
     * RESULT SER FOR CURRENT
     * @param $result
     * @return array
     * @throws AdminException
     */
    protected function resultSetForCurrent($result)
    {
        if (is_object($result) && !empty($result->current())) {
            if ($this->virifyUniqueResult && count($result) > 1) {
                throw new AdminException('The result was higher than a record.');
            }
            return $result->current();
        }
        return array();
    }
}
