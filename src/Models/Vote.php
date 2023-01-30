<?php

namespace App\Models;

use App\Core\DB;

class Vote
{
    protected $connection = null;

    public function __construct()
    {
        $this->connection = DB::getInstance();
    }

    public function create($topicId)
    {
        $sql = "INSERT INTO votes (topic_id, count) 
                    VALUES 
                    (:id, 0)";

        $query = $this->connection->prepare($sql);

        return $query->execute([
            ':id' => $topicId
        ]);
    }

    public function update($topicId)
    {
        $sql = "UPDATE votes 
                SET count = count + 1
                WHERE topic_id = :id";

        $query = $this->connection->prepare($sql);

        return $query->execute([
            ':id' => $topicId,
        ]);
    }

    public function delete($topicId)
    {
        $sql = "DELETE FROM votes 
                WHERE topic_id = :id";

        $query = $this->connection->prepare($sql);

        return $query->execute([
            ':id' => $topicId,
        ]);
    }
}
