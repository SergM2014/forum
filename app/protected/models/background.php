<?php

namespace App\Models;

use App\Core\DataBase;





 class Background extends DataBase
 {

     public static function persistVisitor($userHash)
     {
         $sql= "INSERT INTO `visitors`(`userhash`, `visits_number`) VALUES (?, 1)";
         $stmt = self::conn()->prepare($sql);
         $stmt->bindValue(1, $userHash, \PDO::PARAM_STR);

         $stmt->execute();
     }


     public static function addVisit($userHash)
     {
         $sql ="UPDATE `visitors` SET `visits_number` = `visits_number`+1 WHERE `userhash`=?";
         $stmt = self::conn()->prepare($sql);
         $stmt->bindValue(1, $userHash, \PDO::PARAM_STR);

         $stmt->execute();
     }


     public static function visitorsOnline()
     {
         $sql = "DELETE FROM `online` WHERE `added_at`< (NOW()-60)";
         self::conn()->exec($sql);


         $ip = $_SERVER['REMOTE_ADDR'];

         $sql = "DELETE FROM `online` WHERE `ip`=?";
         $stmt = self::conn()->prepare($sql);
         $stmt->bindValue(1, $ip, \PDO::PARAM_STR);

         $stmt->execute();

         $sql = "INSERT INTO `online` (`ip`) VALUES (?)";
         $stmt = self::conn()->prepare($sql);
         $stmt->bindValue(1, $ip, \PDO::PARAM_STR);

         $stmt->execute();


         $sql = "SELECT COUNT(`id`) AS `number_online` FROM `online`";
         $stmt = self::conn()->query($sql);

         $numberOnline = $stmt->fetchColumn();

         return $numberOnline;
     }

     public static function membersOnline()
     {
         $sql = "SELECT COUNT(`id`) AS `number_online` FROM `online` WHERE `status`='member'";
         $stmt = self::conn()->query($sql);

         $membersOnline = $stmt->fetchColumn();

         return $membersOnline;
     }

     public static function responsesAmount()
     {
         $sql = "SELECT COUNT(`id`) AS `responses_amount` FROM `responses`";
         $stmt = self::conn()->query($sql);
         $responsesAmount = $stmt->fetchColumn();

         return $responsesAmount;
     }


     public static function lastRegisteredMember()
     {
         $sql = "SELECT `name` FROM `members` ORDER BY `added_at`";
         $stmt = self::conn()->query($sql);
         $memberName = $stmt->fetchColumn();

         return $memberName;
     }


     public static function membersAmount()
     {
         $sql = "SELECT COUNT(DISTINCT `id`) FROM `members`";
         $stmt = self::conn()->query($sql);
         $membersAmount = $stmt->fetchColumn();

         return $membersAmount;
     }


 }
