<?php

namespace Admin\Form\Training\Entity;

/**
 * Class Series
 * @package Admin\Form\Training
 */
class SerieEntity
{
    /**
     * @var
     */
    public $phase;
    /**
     * @var
     */
    public $week;
    /**
     * @var
     */
    public $charge;
    /**
     * @var
     */
    public $repetition;

    /**
     * @return mixed
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @param mixed $phase
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;
    }

    /**
     * @return mixed
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @param mixed $week
     */
    public function setWeek($week)
    {
        $this->week = $week;
    }

    /**
     * @return mixed
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * @param mixed $charge
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;
    }

    /**
     * @return mixed
     */
    public function getRepetition()
    {
        return $this->repetition;
    }

    /**
     * @param mixed $repetition
     */
    public function setRepetition($repetition)
    {
        $this->repetition = $repetition;
    }


}