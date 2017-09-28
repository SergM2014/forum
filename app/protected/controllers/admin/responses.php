<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Response;
use App\Models\Topic;
use Lib\TokenService;
use App\Models\CheckForm;
use App\Models\Member;




use function responseDeleted;

class Adminresponses  extends AdminController {

    public function index()
    {
        $pages = Response::countAdminPages();
        $responses = Response::getAllResponses($pages);



        $counter = Response::getTableCounter($pages);

        return ['view' => 'views/admin/responses/index.php', 'responses' => $responses, 'pages' =>$pages, 'counter' =>$counter];
    }

    public function create($errors = null)
    {
       $topics = Topic::getAllTopics();
//get members List
        $members = Member::getAllMembers();

        $_SESSION['createResponse'] = true;
       return ['view' => 'views/admin/responses/create.php', 'topics' => $topics,
           'members' => $members, 'errors' => $errors];

    }


    public function showTreeStructure()
    {


        $responsesDropDownList = (new Response($_POST['id']))->getAdminResponsesTreeStructure();

       return ['view' => 'views/admin/responses/showTreeStructure.php', 'responsesDropDownList' => $responsesDropDownList, 'ajax' => true ];

    }


    public function store()
    {
        TokenService::check('admin');

        if(@!$_SESSION['createResponse']) return $this->create();

        $cleanedUpInputs['response'] = self::stripTags($_POST['response']);

        $errors = CheckForm::checkCreateResponseForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->create($errors);
        };

        Response::store($cleanedUpInputs['response']);

        unset($_SESSION['createResponse']);

        return ['view'=>'views/admin/responses/stored.php' ];
    }


    public function edit($id,$errors = null)
    {
        $response = Response::getOneComment($id);
        $topics = Topic::getAllTopics();


        $_SESSION['editResponse'] = true;
        return ['view' => 'views/admin/responses/edit.php', 'topics' => $topics, 'id' =>$id,
            'errors' => $errors, 'response' => $response];

    }

    public function update($id)
    {
        TokenService::check('admin');

        if(@!$_SESSION['editResponse']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('response');
        $errors = CheckForm::checkCreateResponseForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->edit($id, $errors);
        };

        Response::update($id,$cleanedUpInputs);

        unset($_SESSION['editResponse']);

        return ['view'=>'views/admin/responses/updated.php' ];
    }

    public function modalWindowDelete()
    {
        return ['view'=>'views/admin/modalWindows/deleteResponse.php', 'ajax'=> true ];
    }


    public function delete(){

        TokenService::check('admin');

        Response::delete($_POST['responseId']);
        echo json_encode(['success'=>true, 'message'=> responseDeleted()]); exit();
    }

}
  