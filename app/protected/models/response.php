<?php

namespace App\Models;



use App\Core\DataBase;
use App\Models\Member;

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




    private function getTopicResponses($indentifier)
        {
            $sql = "SELECT `m`.`id` AS `member_id`, `m`.`avatar`, `m`.`name` AS `member_name`, `m`.`added_at` AS `member_added_at`,
            `r`.`id`, `r`.`parent_id`, `r`.`response`, `r`.`created_at`, `t`.`title` FROM `responses` `r` JOIN
                    `topics` `t` ON `t`.`id`= `r`.`topic_id` JOIN `members` `m` ON `m`.`id`= `r`.`member_id`
                     WHERE `t`.`title`= :indentifier OR `t`.`id`= :indentifier
                    AND `r`.`published`='1'";

            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(':indentifier', $indentifier, \PDO::PARAM_STR);
            $stmt->execute();
            $responses = $stmt->fetchAll();
            return $responses;
        }


    public function getResponsesTreeStructure($parent = 0, $responseId)
    {
        $print = "";
        static $leftAttr= 1;

        foreach($this->responses as $response){
            if($response->parent_id == $parent){

                $choosenRespose= (@$responseId == $response->id)? 'choosenResponse': '';
                $ancor = (@$responseId == $response->id) ? "<a name='show'></a>": '';



                $print.= "<li>$ancor<div id='responseId_$response->id' class='response_item left{$leftAttr} $choosenRespose'>
                <div class='response_user_info'>".added().": {$response->member_added_at}";

                    if($response->avatar) {
                        $print.= "<img src= '/uploads/avatars/{$response->avatar}' alt='' class='response-item__avatar'>";
                    }

                    $print.= "<br>".name().":  {$response->member_name}</div><div class='response_user_text'>{$response->response}
                        
                    </div>";

                    if(isset($_SESSION['member'])) {

                        $print.= "<div class='response_answer-container' > 
                            <a href = '#parentComment' >
                                <button type = 'button'class='response_answer-btn' data-response-id = '{$response->id}'
                                 > ".answer()."</button >
                            </a >
                        </div >";
                      }

                    $print.= "</div>";

                    foreach($this->responses as $subresponse){
                        if($subresponse->parent_id == $response->id){ $flag = true;}
                    }

                    if(isset($flag)){
                        $print.= "<ul>";
                        $leftAttr++;
                        $print.= $this->getResponsesTreeStructure($response->id, @$responseId);
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


    public static function getOneComment($id = null )
    {
        $id =  $id?? $_POST['id'];
        $sql = "SELECT `m`.`id` AS `member_id`, `m`.`avatar`, `m`.`name` AS `member_name`, `m`.`added_at` AS `member_added_at`,
            `r`.`id`, `r`.`parent_id`, `r`.`response`, `r`.`created_at`,`r`.`published`, `r`.`changed`, 
            `t`.`id` AS `topic_id`, `t`.`title` AS `topic_title` FROM `responses` `r`  JOIN `members` `m` 
            ON `m`.`id`= `r`.`member_id` JOIN `topics` `t` ON `r`.`topic_id` = `t`.`id` WHERE `r`.`id`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $comment = $stmt->fetch();

        return $comment;
    }

    public static function ConvertTittleToId($title)
    {
        $sql = "SELECT `id` FROM `topics` WHERE `title`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $title, \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->bindColumn(1, $id);
        $stmt->fetch();
        return $id;
    }


    public static function persistResponse($response)
    {
        $memberId = Member::getMemberId();

        $sql = "INSERT INTO `responses` (`topic_id`, `parent_id`, `member_id`, `response`, `published`) VALUES( ?, ?, ?, ?, '1') ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['topicId'], \PDO::PARAM_INT);
        $stmt->bindValue(2, $_POST['parentId'], \PDO::PARAM_INT);
        $stmt->bindValue(3, $memberId, \PDO::PARAM_STR);
        $stmt->bindValue(4, $response, \PDO::PARAM_STR);
        $stmt->execute();
    }


    public static function getTopicNameFromResponse($indentifier)
    {
        $sql = "SELECT `t`.`eng_title` FROM `topics` `t` JOIN `responses` `r` ON `t`.`id`= `r`.`topic_id`";
        $stmt = self::conn()->query($sql);
        $stmt->bindColumn(1, $title);
        $stmt->fetch();
        return $title;
    }


    public static function getAllResponses($pages)
    {
        $page = @$_GET['p']>0? $_GET['p'] : 1;
        $page = $page > $pages? $pages: $page;
        $start = ($page-1)*AMOUNTONPAGEADMIN;


        switch (@$_GET['order']){
            case 'nameAZ': $order = ' `m`.`name` DESC, `r`.`created_at` DESC '; break;
            case 'nameZA': $order = ' `m`.`name` ASC, `r`.`created_at` ASC '; break;
            case 'oldestFirst': $order = ' `r`.`created_at` ASC '; break;
            case 'newestFirst': $order = ' `r`.`created_at` DESC '; break;
            default:  $order = ' `r`.`created_at` DESC '; break;
        }


        $sql = "SELECT `r`.`id`, `r`.`topic_id`, `r`.`response`, `r`.`published`, `r`.`changed`, `r`.`created_at`,
                `m`.`name`, `t`.`title` FROM `responses` `r` JOIN `members` `m` ON `r`.`member_id`=`m`.`id` JOIN `topics` `t`
                 ON `r`.`topic_id` = `t`.`id` ORDER BY $order  LIMIT ?,". AMOUNTONPAGEADMIN;

        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $start, \PDO::PARAM_INT);
        $stmt->execute();
        $responses = $stmt->fetchAll();

        return $responses;
    }

    public static function countAdminPages()
    {
        $sql = "SELECT COUNT(`id`) FROM `responses`";
        $stmt = self::conn()->query($sql);
        $stmt->bindColumn(1, $count);
        $stmt->fetch();

        $pages = ceil($count/AMOUNTONPAGEADMIN);
        return $pages;
    }


//in admin part
     public static function store($response)
     {
         $sql = "INSERT INTO `responses` (`topic_id`, `parent_id`, `member_id`, `response`, `published`) VALUES( ?, ?, ?, ?, ?) ";
         $stmt = self::conn()->prepare($sql);
         $stmt->bindValue(1, $_POST['topicId'], \PDO::PARAM_INT);
         $stmt->bindValue(2, $_POST['parentId'], \PDO::PARAM_INT);
         $stmt->bindValue(3, $_POST['memberId'], \PDO::PARAM_STR);
         $stmt->bindValue(4, $response, \PDO::PARAM_STR);
         $stmt->bindValue(5, $_POST['published'], \PDO::PARAM_INT);
         $stmt->execute();
     }



    public function getAdminResponsesTreeStructure($parent = 0, $responseId = null)
    {

        $print = "";
        static $leftAttr= 1;

        foreach($this->responses as $response){
            if($response->id === $_POST['responseId']) continue;

            if($response->parent_id == $parent){

                $choosenRespose= (@$responseId == $response->id)? 'choosenResponse': '';
                $ancor = (@$responseId == $response->id) ? "<a name='show'></a>": '';



                $print.= "<li>$ancor<div data-response-id='$response->id' class='response_item left{$leftAttr} $choosenRespose'>
                <div class='response_user_info'>".added().": {$response->member_added_at}";

                if($response->avatar) {
                    $print.= "<img src= '/uploads/avatars/{$response->avatar}' alt='' class='response-item__avatar'>";
                }

                $print.= "<br>".name().":  {$response->member_name}</div><div class='response_user_text'>{$response->response}
                        
                    </div>";

                if(isset($_SESSION['member'])) {

                    $print.= "<div class='response_answer-container' > 
                            <a href = '#parentComment' >
                                <button type = 'button'class='response_answer-btn' data-response-id = '{$response->id}'
                                 > ".answer()."</button >
                            </a >
                        </div >";
                }

                $print.= "</div>";

                foreach($this->responses as $subresponse){
                    if($subresponse->parent_id == $response->id){ $flag = true;}
                }

                if(isset($flag)){
                    $print.= "<ul>";
                    $leftAttr++;
                    $print.= $this->getAdminResponsesTreeStructure($response->id, @$responseId);
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


    public static function update($id, $cleanedInputs)
    {

        $sql ="UPDATE `responses` SET `parent_id` = ?, `topic_id` =?, `response` = ?, `published` = ? , `changed` = '1' WHERE `id`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt ->bindValue(1, $_POST['parentId'], \PDO::PARAM_INT);
        $stmt ->bindValue(2, $_POST['topicId'], \PDO::PARAM_INT);
        $stmt ->bindValue(3, $cleanedInputs['response'], \PDO::PARAM_STR);
        $stmt ->bindValue(4, $_POST['published'], \PDO::PARAM_INT);
        $stmt ->bindValue(5, $id, \PDO::PARAM_INT);
        $stmt -> execute();


    }


    public static function delete($id)
    {
        $sql = "DELETE FROM `responses` WHERE `id` =?";
        $stmt = self::conn()->prepare($sql);
        $stmt -> bindValue(1, $id, \PDO::PARAM_INT);
        $stmt ->execute();
    }
 }
