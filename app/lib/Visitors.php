<?php

namespace Lib;

use App\Models\Background;

class Visitors {

    public static function setOne()
    {
        $userhash = @$_COOKIE["userhash"]; // Узнаём, что за пользователь
        if (!$userhash AND @!$_SESSION['visitor']) {
            /* Если это новый пользователь, то добавляем ему cookie, уникальные для него */
            $userhash = uniqid();
            setcookie("userhash", $userhash, 0x6FFFFFFF);
            $_SESSION['visitor'] = true;
            //insert into DB set visits number 1
            Background::persistVisitor($userhash);
        }
         if ($userhash AND !isset($_SESSION['visitor'])) {
             $_SESSION['visitor'] = true;
             Background::addVisit($userhash);
        }

    }


    public static function getOnlineVisitors()
    {
      return  Background::online();
    }

}