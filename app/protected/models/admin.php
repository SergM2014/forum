<?php

namespace App\Models;


use App\Core\DataBase;




class AdminModel extends DataBase
{

    public static function getAdminUser( )
    {
        if (@!$_POST['login'] OR @!$_POST['password']) return;
        $sql = "SELECT `login` , `password`, `role`,  `token` FROM `users` WHERE `login`= ? ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['login'], \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if (password_verify($_POST['password'], @$user->password)) {
            $_SESSION['admin']['login'] = $user->login;
            $_SESSION['admin']['token'] = $user->token;

 //define importence of roles, the largest number the highest role importance
            switch ($user->role) {
                case 'user':       $_SESSION['admin']['role'] = 1; break;
                case 'admin':      $_SESSION['admin']['role'] = 2; break;
                case 'superadmin': $_SESSION['admin']['role'] = 3; break;
            }

        }
    }



}