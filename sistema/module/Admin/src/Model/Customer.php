<?php

namespace Admin\Model;

class Customer
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $active;
    public $create_at;
    public $update_at;

    function exchangeArray(Array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->age = $data['age'] ?? null;
        $this->height = $data['height'] ?? null;
        $this->active = $data['active'] ?? null;
        $this->create_at = $data['create_at'] ?? null;
        $this->update_at = $data['update_at'] ?? null;
    }

    function toArray()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['name'] = $this->name;
        $data['email'] = $this->email;
        $data['password'] = $this->password;
        $data['age'] = $this->age;
        $data['height'] = $this->height;
        $data['active'] = $this->active;
        $data['create_at'] = $this->create_at;
        $data['update_at'] = $this->update_at;
        return $data;
    }
}