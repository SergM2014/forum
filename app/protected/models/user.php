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
//dd($inputs);
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
}