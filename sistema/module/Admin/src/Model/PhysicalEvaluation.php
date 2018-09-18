<?php

namespace Admin\Model;

class PhysicalEvaluation
{
    public $id;
    public $signature_id;
    public $date;
    public $fat_porcentage;
    public $weight;
    public $muscle_mass_porcentage;

    function exchangeArray(Array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->signature_id = $data['signature_id'] ?? null;
        $this->date = $data['date'] ?? null;
        $this->weight = $data['weight'] ?? null;
        $this->fat_porcentage = $data['fat_porcentage'] ?? null;
        $this->muscle_mass_porcentage = $data['muscle_mass_porcentage'] ?? null;
    }

    function toArray()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['signature_id'] = $this->signature_id;
        $data['date'] = $this->date;
        $data['weight'] = $this->weight;
        $data['fat_porcentage'] = $this->fat_porcentage;
        $data['muscle_mass_porcentage'] = $this->muscle_mass_porcentage;

        return $data;
    }
}