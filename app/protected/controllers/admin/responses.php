<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Response;
use App\Models\Topic;
use Lib\TokenService;
use App\Models\CheckForm;
use App\Models\Member;




use function responseDeleted;
use function responsePublished;
use function responseUnpublished;
use function yes;
use function  no;

class AdminResponses  extends AdminController {


    public function __construct()
    {
        parent::__construct();

        $this->checkAdminLevel(2);
    }


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

        $members = Member::getAllMembers();

        $this->setReferrer('createResponse');

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
        $this->checkReferrer('createResponse');
        TokenService::check('admin');

        $cleanedUpInputs['response'] = self::stripTags($_POST['response']);

        $errors = CheckForm::checkCreateResponseForm($cleanedUpInputs);

        if(!empty($errors)) {
            return $this->create($errors);
        };

        Response::store($cleanedUpInputs['response']);

        return ['view'=>'views/admin/completedAction.php', 'action' => 'responseCreatedL' ];
    }


    public function edit($id,$errors = null)
    {
        $response = Response::getOneComment($id);
        $topics = Topic::getAllTopics();

        $this->setReferrer('editResponse');

        return ['view' => 'views/admin/responses/edit.php', 'topics' => $topics, 'id' =>$id,
            'errors' => $errors, 'response' => $response];

    }

    public function update($id)
    {
        $this->checkReferrer('editResponse');
        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('response');
        $errors = CheckForm::checkCreateResponseForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->edit($id, $errors);
        };

        Response::update($id,$cleanedUpInputs);

        return ['view'=>'views/admin/completedAction.php', 'action' => 'responseUpdatedL' ];
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

    public function publish()
    {
        echo json_encode(['success'=>true, 'message'=> responsePublished(), 'text' => yes() ]); exit();
    }

    public function unpublish()
    {
        echo json_encode(['success'=>true, 'message'=> responseUnpublished(), 'text' => no() ]); exit();
    }

}
  