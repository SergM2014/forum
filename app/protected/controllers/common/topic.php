<?php

namespace App\Controllers;



use App\Core\BaseController;




use App\Models\Response;
use Lib\CheckFieldsService;
use App\Models\CheckForm;




class Topic  extends BaseController
  {
    use CheckFieldsService;

    public function showResponses($topic)
	{
       $topicResponses = (new Response($topic))->getResponsesTreeStructure();
//topic should be converted to id
        $id = Response::ConvertTittleToId($topic);


       return ['view'=>'views/common/responses.php', 'topicResponses' => $topicResponses, 'id'=>$id];

    }

    public function addResponse()
    {
        $cleanedUpInputs = self::escapeInputs(/*'name', 'email',*/ 'comment'/*, 'captcha'*/);
        $errors = CheckForm::checkForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            $errors['error'] = true; echo json_encode($errors); exit();
        };
//if success save in db
// $_POST should contains all datas from the form
       // Response::persistResponse($cleanedUpInputs);

        echo json_encode(['success'=>true]); exit();
    }

    public function showParentComment()
    {
        $comment = Response::getOneComment();

        return ['view'=>'views/common/partials/showParentComment.php', 'comment'=>$comment, 'ajax'=>true];
    }



















  }
  