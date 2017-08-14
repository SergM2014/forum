<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Models\Response;
use Lib\CheckFieldsService;
use App\Models\CheckForm;
use App\Models\Member;
use Lib\TokenService;


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

    private function checkIfMember()
    {
        if(!isset($_SESSION['member'])){
            if (isset($_POST['ajax'])){
                echo json_encode(["message" => "you do not have permission to fire off the controller"]); exit();
            }
            header('Location: /signIn');
        }
    }




    public function createCategory($errors = null)
    {

        $this->checkIfMember();
//get all existing Categories
        $categories = (new Member)->getCategoryDropDownTree();

        $_SESSION['createCategory'] = true;

        return ['view'=>'views/common/topic/createCategory.php', 'errors' => $errors, 'categories' => $categories ];
    }


    public function storeCategory()
    {
        $this->checkIfMember();
        TokenService::check('member');

        if(@!$_SESSION['createCategory']) return $this->createCategory();

        $cleanedUpInputs = self::escapeInputs('title');
        $errors = CheckForm::checkCreateCategoryForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->createCategory($errors);
        };

        Member::saveCategory($cleanedUpInputs);

        unset($_SESSION['createCategory']);

        return ['view'=>'views/common/topic/storedCategory.php' ];

    }


    public function create($id, $errors = null )
    {
        $this->checkIfMember();

        $_SESSION['createTopic'] = true;

        return ['view'=>'views/common/topic/create.php', 'errors' => $errors, 'id'=>$id ];
    }

    public function store()
    {
        $this->checkIfMember();
        TokenService::check('member');

        if(@!$_SESSION['createTopic']) return $this->create($_POST['id']);

        $cleanedUpInputs = self::escapeInputs('title');
        $errors = CheckForm::checkCreateTopicForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->create($_POST['id'], $errors);
        };

        Member::saveTopic($cleanedUpInputs);

        unset($_SESSION['createTopic']);

        return ['view'=>'views/common/topic/stored.php' ];
    }



















  }
  