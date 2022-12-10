<?php


class TopicData
{
    protected $connection = null;
    protected $host   = '######'; // localhost or ip address if you are using docker
    protected $dbname = 'suggestron';
    protected $user   = '###'; // if you used docker then put dev or root otherwise
    protected $pwd    = '####'; // password defined on container or on the tool

    public function connect()
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
}
