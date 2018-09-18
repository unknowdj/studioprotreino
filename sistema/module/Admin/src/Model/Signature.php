<?php

namespace Admin\Model;

class Signature
{
    public $id;
    public $plan_id;
    public $customer_id;
    public $date_initial;
    public $date_end;
    public $value;
    public $active;
    public $create_at;
    public $update_at;

    function exchangeArray(Array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->plan_id = $data['plan_id'] ?? null;
        $this->customer_id = $data['customer_id'] ?? null;
        $this->date_initial = $data['date_initial'] ?? null;
        $this->date_end = $data['date_end'] ?? null;
        $this->value = $data['value'] ?? null;
        $this->active = $data['active'] ?? null;
        $this->create_at = $data['create_at'] ?? null;
        $this->update_at = $data['update_at'] ?? null;
    }

    function toArray()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['plan_id'] = $this->plan_id;
        $data['customer_id'] = $this->customer_id;
        $data['date_initial'] = $this->date_initial;
        $data['date_end'] = $this->date_end;
        $data['value'] = $this->value;
        $data['active'] = $this->active;
        $data['create_at'] = $this->create_at;
        $data['update_at'] = $this->update_at;
        return $data;
    }
}