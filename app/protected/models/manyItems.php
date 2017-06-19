<?php

namespace App\Models;

use App\Core\DataBase;
use Gregwar\Captcha\CaptchaBuilder;

 class ManyItems extends DataBase
 {


     public static function getOneItem()
     {
         $sql = "SELECT `mi`.`id`, `mi`.`title`, `mi`.`describtion`, 
                  GROUP_CONCAT(`i`.`image` ORDER BY `i`.`position_number` ASC) AS `images` 
                  FROM `many_items` `mi` JOIN `images` `i` ON `i`.`many_item_id`= `mi`.`id` WHERE `mi`.`id`= 1  ";
         $stmt = self::conn()->query($sql);
         $result = $stmt->fetch();

         if($result->images){
             $array = explode(',', $result->images);
             $result->imagesArray = $array;
         }

         if(isset($_POST['imageData'])){
             $imagesPostArray= @explode(',',$_POST['imageData']);
             $result->imagesArray = $imagesPostArray;
         }

         return $result;
     }



     public static function updateItem($cleanedUpInputs)
     {
         //initialy update title and description
        $sql = "UPDATE `many_items` SET `title` =?, `describtion`=?";
        $stmt= self::conn()->prepare($sql);
        $stmt->bindValue(1, $cleanedUpInputs['title'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $cleanedUpInputs['describtion'], \PDO::PARAM_STR);
        $stmt->execute();

//         this block is respomsible for
         $sql="DELETE FROM `images` WHERE `many_item_id`= 1";
         self::conn()->query($sql);

         if($_POST['imageData']== '')return;

         $imagesArray = explode(',', $_POST['imageData']);

         $sql = "INSERT INTO `images` (`many_item_id`, `image`, `position_number`) VALUES (1, ?, ?)";
         $stmt = self::conn()->prepare($sql);

         $size = count($imagesArray);
         for($i = 0; $i<$size; $i++ ){

             $stmt->bindValue(1, $imagesArray[$i], \PDO::PARAM_STR);
             $stmt->bindValue(2, $i, \PDO::PARAM_INT);
             $stmt->execute();


         }

     }



 }
