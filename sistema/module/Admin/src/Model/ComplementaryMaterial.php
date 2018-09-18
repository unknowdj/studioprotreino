<?php

namespace Admin\Model;

/**
 * Class ComplementaryMaterial
 * @package Admin\Model
 */
class ComplementaryMaterial
{
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $signature_id;
    /**
     * @var
     */
    public $movie_id;
    /**
     * @var
     */
    public $training_id;

    /**
     * @param array $data
     */
    function exchangeArray(Array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->signature_id = $data['signature_id'] ?? null;
        $this->movie_id = $data['movie_id'] ?? null;
        $this->training_id = $data['training_id'] ?? null;
    }

    /**
     * @return array
     */
    function toArray()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['signature_id'] = $this->signature_id;
        $data['movie_id'] = $this->movie_id;
        $data['training_id'] = $this->training_id;
        return $data;
    }
}