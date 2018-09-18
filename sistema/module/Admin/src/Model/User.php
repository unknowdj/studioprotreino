<?php

namespace Admin\Model;

class User
{
    public $id;
    public $name;
    public $user;
    public $password;

    function exchangeArray(Array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->user = $data['user'] ?? null;
        $this->password = $data['password'] ?? null;
    }

    function toArray()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['name'] = $this->name;
        $data['user'] = $this->user;
        $data['password'] = $this->password;
        return $data;
    }
}