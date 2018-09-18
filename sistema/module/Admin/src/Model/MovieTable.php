<?php

namespace Admin\Model;

use MainClass\MainController;
use MainClass\MainModel;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Class MovieTable
 * @package Admin\Model
 */
class MovieTable extends MainModel
{
    /**
     * MovieTable constructor.
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * SAVE
     * @param Movie $movie
     * @return mixed
     */
    public function save(Movie $movie, $id)
    {
        return parent::saveData((int)$id, $movie);
    }

    /**
     * @return array|\Zend\Paginator\Paginator
     */
    public function getMoviesActive($userId, $signatureId)
    {
        $select = new Select();
        $select
            ->from(['s' => 'signature'])
            ->columns([])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title'])
            ->join(['c' => 'customers'], 's.customer_id = c.id', [])
            ->join(['cm' => 'complementary_material'], 'cm.signature_id = s.id', [])
            ->join(['m' => 'movies'], 'cm.movie_id = m.id', ['title', 'description', 'embed'])
            ->where(['p.active' => MainController::ACTIVE])
            ->where(['c.active' => MainController::ACTIVE])
            ->where(['m.active' => MainController::ACTIVE])
            ->where(['c.id' => $userId])
            ->where(['s.id' => $signatureId]);
        return $this->fetchBySelect($select);
    }
}