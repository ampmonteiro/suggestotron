<?php


class TopicData
{
    protected $connection = null;
    protected $host   = '172.17.0.3'; // localhost or ip address if you are using docker
    protected $dbname = 'suggestron';
    protected $user   = 'root'; // if you used docker then put dev or root otherwise
    protected $pwd    = 'secret'; // password defined on container or on the tool

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->connection = new PDO(
            "mysql:host={$this->host};dbname={$this->dbname}",
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
}
