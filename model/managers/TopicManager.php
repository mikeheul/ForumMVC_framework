<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager
{

    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";


    public function __construct()
    {
        parent::connect();
    }

    public function findAllTopics(array $order = null, int $id)
    {
        $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

                $sql = "SELECT id_topic, title, dateTopic, locked, t.user_id, COUNT(p.topic_id) AS nbPosts
                    FROM " . $this->tableName. " t 
                    LEFT JOIN post p ON t.id_topic = p.topic_id 
                    WHERE t.category_id = :id
                    GROUP BY t.id_topic "
                    . $orderQuery; 

        return  $this->getMultipleResults(
            DAO::select($sql, ["id" => $id]),
            $this->className
        );
    }

    public function lockTopic($id) {

        $sql = "UPDATE topic SET locked = 1 WHERE id_topic = :id";
        DAO::update($sql, ["id" => $id]);
    }

    public function unlockTopic($id) {

        $sql = "UPDATE topic SET locked = 0 WHERE id_topic = :id";
        DAO::update($sql, ["id" => $id]);
    }
}
