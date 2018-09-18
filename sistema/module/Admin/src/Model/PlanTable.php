<?php

namespace Admin\Model;

use MainClass\MainController;
use MainClass\MainModel;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Class PlanTable
 * @package Admin\Model
 */
class PlanTable extends MainModel
{
    /**
     * PlanTable constructor.
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
            ->from(['p' => 'plans'])
            ->join(['pc' => 'plan_categories'], 'p.category_id = pc.id', ['category' => 'name'], 'left');
        return $this->fetchBySelect($select);
    }

    /**
     * SAVE
     * @param Plan $plan
     * @return mixed
     */
    public function save(Plan $plan, $id)
    {
        return parent::saveData((int)$id, $plan);
    }

    /**
     * @return array
     */
    public function fetchPlanActiveWithCategory()
    {
        $select = new Select();
        $select
            ->from(['p' => 'plans'])
            ->join(['pc' => 'plan_categories'], 'p.category_id = pc.id', ['category' => 'name'])
            ->where(['p.active' => MainController::ACTIVE]);
        $plans = $this->fetchBySelect($select);

        $arrPlans = [];
        foreach ($plans as $plan) {
            $arrPlans[$plan['category']][] = $plan;
        }

        return $arrPlans;
    }

    /**
     * @return array
     */
    public function fetchPlanActive()
    {
        $select = new Select();
        $select
            ->from(['p' => 'plans'])
            ->join(['pc' => 'plan_categories'], 'p.category_id = pc.id', ['category' => 'name'])
            ->where(['p.active' => MainController::ACTIVE])
            ->order(['pc.name ASC', 'p.title ASC']);
        return $this->fetchBySelect($select);
    }

    /**
     * @return array
     */
    public function fetchPlanCategory()
    {
        $select = new Select();
        $select->from(['p' => 'plan_categories']);
        return $this->fetchBySelect($select);
    }
}