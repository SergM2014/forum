<?php

namespace App\Models;



use App\Core\DataBase;

use function added;
use function name;
use function answer;


 class Response extends DataBase
 {

     public  $responses;

     public function __construct($topic)
     {
         $this->responses = $this->getTopicResponses($topic);
     }




    private function getTopicResponses($topic)
        {
            $sql = "SELECT `m`.`id` AS `member_id`, `m`.`avatar`, `m`.`name` AS `member_name`, `m`.`added_at` AS `member_added_at`,
            `r`.`id`, `r`.`parent_id`, `r`.`response`, `r`.`created_at`, `t`.`title` FROM `responses` `r` JOIN
                    `topics` `t` ON `t`.`id`= `r`.`topic_id` JOIN `members` `m` ON `m`.`id`= `r`.`member_id` WHERE `t`.`title`=?";

            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(1, $topic, \PDO::PARAM_STR);
            $stmt->execute();
            $responses = $stmt->fetchAll();
            return $responses;
        }


    public function getResponsesTreeStructure($parent = 0)
    {
        $print = "";
        static $leftAttr= 1;

        foreach($this->responses as $response){
            if($response->parent_id == $parent){
                $print.= "<li><div class='response_item left{$leftAttr}'>
                <div class='response_user_info'>".added().": {$response->member_added_at}";

                    if($response->avatar) {
                        $print.= "<img src= '{$response->avatar}' alt=''>";
                    }

                    $print.= "<br>".name().":  {$response->member_name}</div><div class='response_user_text'>{$response->response}
                        
                    </div>
                        <div class='response_answer-container'> 
                        <a href='#parentComment'>
                            <button type='button'class='response_answer-btn' data-response-id='{$response->id}'>".answer()."</button>
                        </a>
                        </div>
                    </div>";

                    foreach($this->responses as $subresponse){
                        if($subresponse->parent_id == $response->id){ $flag = true;}
                    }

                    if(isset($flag)){
                        $print.= "<ul>";
                        $leftAttr++;
                        $print.= $this->getResponsesTreeStructure($response->id);
                        $print.= "</ul>";
                        $leftAttr--;
                        $print.= "</li>";
                        $flag = null;
                    } else {
                        $print.= "</li>";
                    }
            }
        }
        return $print;
    }


    public static function getOneComment()
    {
        $id = $_POST['id'];
        $sql = "SELECT `m`.`id` AS `member_id`, `m`.`avatar`, `m`.`name` AS `member_name`, `m`.`added_at` AS `member_added_at`,
            `r`.`id`, `r`.`parent_id`, `r`.`response`, `r`.`created_at` FROM `responses` `r`  JOIN `members` `m` 
            ON `m`.`id`= `r`.`member_id` WHERE `r`.`id`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $comment = $stmt->fetch();

        return $comment;
    }

    public static function ConvertTittleToId($title)
    {
        $sql ="SELECT `id` FROM `topics` WHERE `title`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $title, \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->bindColumn(1, $id);
        $stmt->fetch();
        return $id;
    }


//    public static function persistResponse($fields)
//    {
//        $sql = "INSERT INTO `responses` "
//    }


 }
