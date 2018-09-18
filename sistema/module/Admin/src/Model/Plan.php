<?php

namespace Admin\Model;

class Plan
{
    public $id;
    public $category_id;
    public $title;
    public $description;
    public $active;
    public $value;
    public $create_at;
    public $update_at;

    function exchangeArray(Array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->category_id = $data['category_id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->value = $data['value'] ?? null;
        $this->active = $data['active'] ?? null;
        $this->create_at = $data['create_at'] ?? null;
        $this->update_at = $data['update_at'] ?? null;
    }

    function toArray()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['category_id'] = $this->category_id;
        $data['title'] = $this->title;
        $data['description'] = $this->description;
        $data['value'] = $this->value;
        $data['active'] = $this->active;
        $data['create_at'] = $this->create_at;
        $data['update_at'] = $this->update_at;
        return $data;
    }
}