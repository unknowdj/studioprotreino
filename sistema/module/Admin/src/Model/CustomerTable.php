<?php

namespace Admin\Model;

use MainClass\AdminException;
use MainClass\MainController;
use MainClass\MainModel;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\Exception\RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Class CustomerTable
 * @package Admin\Model
 */
class CustomerTable extends MainModel
{

    /**
     * CustomerTable constructor.
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    /**
     * @return mixed
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * SAVE
     * @param Customer $customer
     * @return mixed
     */
    public function save(Customer $customer, $id)
    {
        return parent::saveData((int)$id, $customer);
    }

    /**
     * @param $user
     * @param $password
     * @return mixed
     * @throws AdminException
     */
    public function findByUserForAutentication($user, $password)
    {
        $select = new Select();
        $select
            ->from(['s' => 'signature'])
            ->columns(['date_initial', 'date_end'])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title'])
            ->join(['c' => 'customers'], 's.customer_id = c.id', ['*'])
            ->where(['s.active' => MainController::ACTIVE])
            ->where(['p.active' => MainController::ACTIVE])
            ->where(['c.active' => MainController::ACTIVE])
            ->where(['c.email' => $user]);
        $row = $this->resultSetForCurrent($this->execSQL($select));

        if (!$row) {
            throw new RuntimeException(sprintf(
                'Nenhum usuário ativo com a descrição "%s" foi encontrado', $user
            ));
        }

        if ((strtotime($row['date_initial']) > strtotime(date('Y-m-d 00:00:00')))) {
            throw new AdminException(sprintf(
                'Sua assinatura inicia em: %s', MainController::formatDate($row['date_initial'])
            ));
        }

        if ((strtotime($row['date_end']) < strtotime(date('Y-m-d')))) {
            throw new AdminException(sprintf(
                'Sua assinatura terminou em %s por favor renove sua assinatura.', MainController::formatDate($row['date_end'])
            ));
        }

        if (!$this->confirmPassword($password, $row['password'])) {
            throw new AdminException('Email ou senha são inválido');
        }

        return $row;
    }

    /**
     * @param $userId
     * @return array|\Zend\Paginator\Paginator
     */
    public function getPlanActive($userId)
    {
        $select = new Select();
        $select
            ->from(['s' => 'signature'])
            ->columns(['id', 'date_initial', 'date_end', 'active'])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title'])
            ->join(['c' => 'customers'], 's.customer_id = c.id', ['customer_name' => 'name'])
            ->where(['s.active' => MainController::ACTIVE])
            ->where(['p.active' => MainController::ACTIVE])
            ->where(['c.active' => MainController::ACTIVE])
            ->where(['c.id' => $userId]);
        return $this->fetchBySelect($select);
    }

    /**
     * @param $post
     * @return bool
     */
    public function passwordWasUpdated($post)
    {
        if (!empty($post->password)) {
            return true;
        }
        return false;
    }

    /**
     * GENERATE PASSWORD
     * @param string $password
     * @return string
     */
    public function generatePassword($password)
    {
        $bCrypt = new Bcrypt();
        return $bCrypt->create($password);
    }

    /**
     * CONFIRM PASSWORD
     * @param string $password
     * @param string $hash
     * @return string
     */
    public function confirmPassword($password, $hash)
    {
        $bCrypt = new Bcrypt();
        return $bCrypt->verify($password, $hash);
    }
}