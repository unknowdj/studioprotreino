<?php

namespace Admin\Model;

use MainClass\MainModel;
use Zend\Authentication\Adapter\DbTable\Exception\RuntimeException;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Class UserTable
 * @package Admin\Model
 */
class UserTable extends MainModel
{
    /**
     * UserTable constructor.
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * SAVE
     * @param User $user
     * @return mixed
     */
    public function save(User $user, $id = null)
    {
        return parent::saveData((int)$id, $user);
    }

    /**
     * @param $user
     * @param $password
     * @return mixed
     */
    public function findByUserForAutentication($user, $password)
    {
        $rowset = $this->tableGateway->select(['user' => $user]);
        $row = $rowset->current();

        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not retrieve the row %s', $user
            ));
        }

        if (!$this->confirmPassword($password, $row->password)) {
            throw new AdminException('Email ou senha são inválido');
        }

        return $row;
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