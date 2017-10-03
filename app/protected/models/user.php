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
}