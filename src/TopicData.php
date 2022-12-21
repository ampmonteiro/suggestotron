<?php

namespace App;

use App\Core\Config;

class TopicData
{
    protected $connection = null;
    // localhost or ip address if you are using docker
    // if you used docker then put dev or root otherwise
    protected $user   = null;
    // password defined on container or on the tool
    protected $pwd    = null;
    protected $dsn    = null;

    public function __construct()
    {
        $config = Config::get('database');

        $this->user = $config['username'];

        $this->pwd = $config['password'];

        $this->dsn = "{$config['drive']}:host={$config['hostname']};dbname={$config['dbname']}";

        $this->connect();
    }

    private function connect()
    {
        $this->connection = new \PDO(
            $this->dsn,
            $this->user,
            $this->pwd
        );
    }

    public function getAllTopics()
    {
        $query = $this->connection->prepare("SELECT * FROM topics");
        $query->execute();

        return $query;
    }

    public function create($data)
    {
        $sql = "INSERT INTO topics (
                                title,
                                description
                            ) 
                VALUES (
                        :title,
                        :description
                        )";

        $query = $this->connection->prepare($sql);

        $query->execute([
            ':title'       => $data['title'],
            ':description' => $data['description']
        ]);
    }

    public function getTopic($id)
    {
        $sql = "SELECT * 
                FROM topics 
                WHERE id = :id 
                LIMIT 1";

        $query = $this->connection->prepare($sql);

        $query->execute([':id' => $id]);

        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $query = $this->connection->prepare(
            "UPDATE topics 
            SET 
                title = :title, 
                description = :description
            WHERE
                id = :id"
        );

        $data = [
            ':id'          => $data['id'],
            ':title'       => $data['title'],
            ':description' => $data['description']
        ];

        return $query->execute($data);
    }

    public function delete($id)
    {
        $query = $this->connection->prepare(
            " DELETE FROM topics
                WHERE id = :id
            "
        );

        return $query->execute([
            ':id' => $id,
        ]);
    }
}
