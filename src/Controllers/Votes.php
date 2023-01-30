<?php

namespace App\Controllers;

use App\Models\Vote;

class Votes
{
    protected $model;

    public function __construct()
    {
        $this->model = new Vote();
    }

    public function update($params)
    {
        if (empty($params['id'])) {
            echo "No topic id specified!";
            exit;
        }

        $this->model->update($params['id']);

        header("Location: /");
    }
}
