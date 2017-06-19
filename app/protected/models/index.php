<?php

namespace App\Models;

use App\Core\DataBase;
use Gregwar\Captcha\CaptchaBuilder;




 class Index extends DataBase
 {
     public static function printCaptcha()
     {
         $builder = new CaptchaBuilder;
         $builder->build();
         $_SESSION['phrase'] = $builder->getPhrase();
         return $builder;
     }

     public static function getUser()
     {
         $sql = "SELECT `id`, `avatar`, `login`, `email` FROM `subscribers` WHERE `id`=1";
         $stmt = self::conn()->query($sql);

         $user = $stmt->fetch();

         return $user;
     }

     public static function updateUser($inputs)
     {
         var_dump($inputs);
     }

 }
