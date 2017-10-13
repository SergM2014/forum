<?php

namespace App\Models;



use App\Core\DataBase;
use Lib\HelperService;
use Lib\LangService;

class User extends DataBase
{
    public static function countUsersPages()
    {
        $sql = "SELECT COUNT(`id`) FROM `users`";
        $stmt = self::conn()->query($sql);
        $stmt->bindColumn(1, $count);
        $stmt->fetch();

        $pages = ceil($count/AMOUNTONPAGEADMIN);
        return $pages;

    }


    public static function getAllUsers($pages)
    {
        $page = @$_GET['p']>0? $_GET['p'] : 1;
        $page = $page > $pages? $pages: $page;
        $start = ($page-1)*AMOUNTONPAGEADMIN;

        $sql = "SELECT `id`,  `avatar`, `login`, `email`, `role`, `created_at` FROM `users` LIMIT $start, ".AMOUNTONPAGEADMIN;
        $stmt = self::conn()->query($sql);
        $members = $stmt->fetchAll();

        return $members;
    }

    public static function store($inputs)
    {
        $token = bin2hex(random_bytes(5));
        $password = $hash = password_hash( $inputs['password'], PASSWORD_DEFAULT );
        $sql = "INSERT INTO `users` (`login`, `password`, `email`, `role`,  `token` ) VALUES (?, ?, ?, ?, ?)";
        $stmt = self::conn()->prepare($sql);
        $stmt -> bindValue(1, $inputs['login'], \PDO::PARAM_INT);
        $stmt -> bindValue(2, $password, \PDO::PARAM_STR);
        $stmt -> bindValue(3, $inputs['email'], \PDO::PARAM_STR);
        $stmt -> bindValue(4, $inputs['role'], \PDO::PARAM_STR);
        $stmt -> bindValue(5, $token, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function find($id)
    {
        $sql = "SELECT `id`, `avatar`, `login`, `email`, `role`, `token`, `created_at` FROM `users` WHERE `id` = ?";
        $stmt = self::conn()->prepare($sql);
        $stmt -> bindValue(1, $id, \PDO::PARAM_INT);
        $stmt -> execute();
        $user = $stmt->fetch();
        return $user;
    }


    public static function update($id, $inputs)
    {
        if($inputs['password']!=''){

            $password = password_hash($inputs['password'], PASSWORD_DEFAULT );

            $sql = "UPDATE `users` SET  `password` = ? WHERE `id`= ?";
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(1, $password, \PDO::PARAM_STR);
            $stmt->bindValue(2, $id, \PDO::PARAM_INT);
            $stmt->execute();
        }


        $sql = "UPDATE `users` SET  `login` = ?,  `email` = ?, `role` = ? WHERE `id`= ?";
        $stmt = self::conn()->prepare($sql);

        $stmt->bindValue(1, $inputs['login'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $inputs['email'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $inputs['role'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $id, \PDO::PARAM_INT);
        $stmt->execute();
    }


    public static function delete($id)
    {
        $sql = "DELETE FROM `users` WHERE `id` = ?";
        $stmt = self::conn()->prepare($sql);
        $stmt ->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt ->execute();
    }

}