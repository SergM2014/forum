<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Models\Response;
use Lib\CheckFieldsService;
use App\Models\CheckForm;
use App\Models\Member;



class Topic  extends BaseController
  {
    use CheckFieldsService;

    public function showResponses($topic, $responseId = false)
	{
       $topicResponses = (new Response($topic))->getResponsesTreeStructure($parent = 0, $responseId);
//topic should be converted to id
        $id = Response::ConvertTittleToId($topic);


       return ['view'=>'views/common/topic/index.php', 'topicResponses' => $topicResponses, 'id'=>$id];
    }


    public function addResponse()
    {
        $cleanedUpInputs = self::escapeInputs('comment');
        $errors = CheckForm::checkForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            $errors['error'] = true; echo json_encode($errors); exit();
        };
//if success save in db
        Response::persistResponse($cleanedUpInputs['comment']);
        echo json_encode(['success'=>true]); exit();
    }


    public function showParentComment()
    {
        $comment = Response::getOneComment();
        return ['view'=>'views/common/partials/showParentComment.php', 'comment'=>$comment, 'ajax'=>true];
    }


    public function showOneResponse($responseId)
    {
        $topic = Response::getTopicNameFromResponse($responseId);

        $topicResponses = (new Response($topic))->getResponsesTreeStructure($parent = 0, $responseId);
//topic should be converted to id
        $id = Response::ConvertTittleToId($topic);

        return ['view'=>'views/common/topic/response.php', 'topicResponses' => $topicResponses, 'id'=>$id, 'topic'=>$topic ];
    }



















  }
  