<?php

namespace App\Controllers;

class Topics
{
    protected $model;

    public function __construct()
    {
        $this->model = new \App\Models\Topic();
    }

    public function index()
    {
        $result = $this->model->all();

        $title = 'List of Topics';

        view('index')
            ->render(
                compact('title', 'result'),
                'base'
            );
    }

    public function create()
    {
        if (isset($_POST) && sizeof($_POST) > 0) {

            $this->model->create($_POST);

            header("Location: /");
            exit;
        }

        $title = 'New Topic';

        render(
            'create',
            compact('title'),
            'base'
        );
    }

    public function edit($params)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($params['id'])) {

            if ($this->model->update($_POST)) {
                header("Location: /");
                exit;
            }

            die("An error occurred");
        }

        $id = $params['id'] ?? null;

        if (!$id) {
            die("You did not pass in an ID.");
        }

        $topic = $this->model->find($id);

        // if not found returns false
        if (!$topic) {
            die("Topic not found!");
        }

        $title = "Edit Topic - {$topic['title']}";

        render(
            'edit',
            compact('title', 'topic'),
            'base'
        );
    }

    public function delete($params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            die("You did not pass in an ID.");
        }

        $topic = $this->model->find($id);

        // if not found returns false
        if (!$topic) {
            die("Topic not found!");
        }

        if ($this->model->delete($topic['id'])) {
            header("Location: /");
            exit;
        }

        die("An error occurred");
    }
}
