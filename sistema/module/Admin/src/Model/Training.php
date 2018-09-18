<?php

namespace Admin\Model;

class Training
{
    public $id;
    public $training_id;
    public $title;
    public $description;
    public $series;
    public $active;

    function exchangeArray(Array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->training_id = $data['training_id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->series = $data['series'] ?? null;
        $this->active = $data['active'] ?? null;
    }

    function toArray()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['training_id'] = $this->training_id;
        $data['title'] = $this->title;
        $data['description'] = $this->description;
        $data['series'] = $this->series;
        $data['active'] = $this->active;
        return $data;
    }
}