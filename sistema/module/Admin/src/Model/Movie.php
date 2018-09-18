<?php

namespace Admin\Model;

class Movie
{
    public $id;
    public $title;
    public $description;
    public $embed;
    public $active;
    public $create_at;
    public $update_at;

    function exchangeArray(Array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->embed = $data['embed'] ?? null;
        $this->active = $data['active'] ?? null;
        $this->create_at = $data['create_at'] ?? null;
        $this->update_at = $data['update_at'] ?? null;
    }

    function toArray()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['title'] = $this->title;
        $data['description'] = $this->description;
        $data['embed'] = $this->embed;
        $data['active'] = $this->active;
        $data['create_at'] = $this->create_at;
        $data['update_at'] = $this->update_at;
        return $data;
    }
}