<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager
{

    protected $className = "Model\Entities\User";
    protected $tableName = "user";


    public function __construct()
    {
        parent::connect();
    }

    public function findOneByEmail($email){

        $sql = "SELECT *
                FROM ".$this->tableName." a
                WHERE a.email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false), 
            $this->className
        );
    }

    public function findOneByUser($nickname){

        $sql = "SELECT *
                FROM ".$this->tableName." a
                WHERE a.nickname = :nickname";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['nickname' => $nickname], false), 
            $this->className
        );
    }

    public function retrievePassword($email){

        $sql = "SELECT *
        FROM ".$this->tableName." a
        WHERE a.email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false), 
            $this->className
        );
    }
}
