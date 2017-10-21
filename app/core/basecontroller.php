<?php

namespace App\Core;

use Lib\CookieService;

/**
 *
 * the parent for all controllersd
 * Class BaseController
 * @package App\Core
 */
 class BaseController
 {
     /**
      *
      * initialize session
      * BaseController constructor.
      */

     public function __construct()
     {
        @session_start();

        CookieService::getUserCookies();
     }

     protected function alreadySignedUser()
     {
         if(@isset($_SESSION['user']['login'])) {header("Location: /subscribtion/signed");}
     }


     protected function ifNotSubscribed()
     {
         if(@!isset($_SESSION['user']['login'])) {header('Location: /subscribtion/signIn');}
     }

     protected function checkReferrer($referrer)
     {
        $url = @$_SESSION['form'][$referrer];

       if( preg_match("/$referrer$/", $url)){

         $_SESSION['form'] = [];
         return;
       };

         $location = @$_SERVER['HTTP_REFERER'];
         header("Location:$location");
         exit();
     }

     protected function setReferrer($referrer)
     {
         $_SESSION['form'] = [];
         $_SESSION['form'][$referrer] = $referrer;
     }




 }
 
?>