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

    public function update()
    {
        $id = $_POST['id'];

        if (empty($id)) {
            die("No topic id specified!");
        }

        $this->model->update($id);

        header("Location: /");
    }
}
