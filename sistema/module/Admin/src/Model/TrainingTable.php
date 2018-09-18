<?php
/**
 * Project: O que fazer culinária
 * ==================================
 * Dev: Rafael Silva
 * Email: contato@pantoneweb.com.br
 * Phone: +55 14 9-9747-2101
 * ==================================
 */

namespace Admin\Model;

use MainClass\MainController;
use MainClass\MainModel;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Class TrainingTable
 * @package Admin\Model
 */
class TrainingTable extends MainModel
{
    /**
     * TrainingTable constructor.
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * SAVE
     * @param Training $training
     * @return mixed
     */
    public function save(Training $training, $id)
    {
        return parent::saveData((int)$id, $training);
    }

    /**
     *
     */
    public function getFathers()
    {
        $select = new Select();
        $select
            ->from('trainings')
            ->where
            ->isNull('training_id')
            ->or
            ->expression('training_id = ?', MainController::NOT_ACTIVE);
        return $this->resultSetForArray($this->fetchBySelect($select));
    }


    /**
     * @param $userId
     * @param $signatureId
     * @return array
     */
    public function getTariningActive($userId, $signatureId)
    {
        $data = [];
        $select = new Select();
        $select
            ->from(['s' => 'signature'])
            ->columns([])
            ->join(['p' => 'plans'], 's.plan_id = p.id', ['plan_name' => 'title'])
            ->join(['c' => 'customers'], 's.customer_id = c.id', [])
            ->join(['cm' => 'complementary_material'], 'cm.signature_id = s.id', [])
            ->join(['t' => 'trainings'], 'cm.training_id = t.id', ['*'])
            ->where(['p.active' => MainController::ACTIVE])
            ->where(['c.active' => MainController::ACTIVE])
            ->where(['t.active' => MainController::ACTIVE])
            ->where(['c.id' => $userId])
            ->where(['s.id' => $signatureId]);
        $trainingFathers = $this->resultSetForArray($this->fetchBySelect($select));

        foreach ($trainingFathers as $trainingFather) {
            $data['trainingFather'][(int)$trainingFather['id']] = $trainingFather;
            $trainingChilds = $this->tableGateway->select(['training_id' => $trainingFather['id']])->toArray();
            foreach ($trainingChilds as $trainingChild) {
                if (!empty($trainingChild['series'])) {
                    $series = json_decode($trainingChild['series']);
                    foreach ($series as $serie) {
                        $ser[$serie->phase][(int)$trainingChild['training_id']][(int)$trainingChild['id']][$serie->week] = $serie;
                    }
                }
                $data[(int)$trainingChild['training_id']][(int)$trainingChild['id']] = $trainingChild;
                $data['series'] = $ser;
            }
        }

        if (!empty($data))
            ksort($data['series']);

        return $data;
    }
}