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
        $error = [];
        $old = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $error = $this->validate($_POST);

            if (empty($error)) {
                $this->model->create($_POST);

                header("Location: /");
                exit;
            }

            $old = $_POST;
        }

        $title = 'New Topic';

        render(
            'create',
            compact('title', 'error', 'old'),
            'base'
        );
    }

    public function edit($params)
    {
        $error = [];
        $old = [];

        $title = "Edit Topic";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($params['id'])) {

            $error = $this->validate($_POST);

            if (empty($error) && $this->model->update($_POST)) {
                header("Location: /");
                exit;
            }

            if (!empty($error)) {

                $old = $_POST;
            }
        }

        $id = $old['id'] ?? $params['id'] ?? null;

        if (!$id) {
            die("You did not pass in an ID.");
        }

        $data = $this->model->find($id);

        // if not found returns false
        if (!$data) {
            die("Topic not found!");
        }

        render(
            'edit',
            compact('title', 'data', 'error', 'old'),
            'base'
        );
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;

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

    protected function validate($data)
    {
        $error = [];

        if (empty($data['title'])) {
            $error['title'] = 'It is required';
        }

        if (empty($data['description'])) {
            $error['description'] = 'It is required';
        }

        return $error;
    }
}
