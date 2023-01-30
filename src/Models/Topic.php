<?php

namespace App\Models;

use App\Core\DB;

class Topic
{
    protected $connection = null;

    public function __construct()
    {
        $this->connection = DB::getInstance();
    }

    public function all()
    {
        $sql = "SELECT  T.*,
                        V.count
                FROM topics T
                INNER JOIN votes V ON  V.topic_id = T.id";

        $query = $this->connection->prepare($sql);
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

        $lastId = $this->connection->lastInsertId();

        (new Vote())->create($lastId);
    }

    public function find($id)
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

        $rs =  $query->execute([
            ':id' => $id,
        ]);

        if (!$rs) {
            return false;
        }

        return (new Vote())->delete($id);
    }
}
