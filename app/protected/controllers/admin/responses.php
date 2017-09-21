<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Response;
use App\Models\Topic;
use Lib\TokenService;
use App\Models\CheckForm;
use App\Models\Member;


use function topicDeleted;

class Adminresponses  extends AdminController {

    public function index()
    {
        $responses = Response::getAllResponses();
        $pages = Response::countAdminPages();
        return ['view' => 'views/admin/responses/index.php', 'responses' => $responses, 'pages' =>$pages];
    }

    public function create($errors = null)
    {
       $topics = Topic::getAllTopics();
//get members List
        $members = Member::getAllMembers();

        $_SESSION['createResponse'] = true;
       return ['view' => 'views/admin/responses/create.php', 'topics' => $topics, //'responsesDropDownList' => $responsesDropDownList,
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
        $topic = Topic::getOneTopic($id);

        $selectedCategory = $_POST['categoryId']?? $topic->category_id;

        $categoryDropDownList = (new Category)->getCategoryDropDownTree($selectedCategory);

        $members = Member::getAllMembers();

        $_SESSION['updateTopic'] = true;
        return ['view' => 'views/admin/topics/edit.php', 'categoryDropDownList' => $categoryDropDownList, 'id'=> $id,
            'categoryId' => $id, 'title' => $topic->title, 'members' => $members, 'memberId' => $topic->member_id,
            'errors' => $errors];

    }

    public function update($id)
    {
        TokenService::check('admin');

        if(@!$_SESSION['updateTopic']) return $this->edit($id);

        $cleanedUpInputs = self::escapeInputs('title');
        $errors = CheckForm::checkUpdateCategoryForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->edit($id, $errors);
        };

        Topic::update($id,$cleanedUpInputs);

        unset($_SESSION['updateTopic']);

        return ['view'=>'views/admin/topics/updated.php' ];
    }

    public function modalWindowDelete()
    {
        return ['view'=>'views/admin/modalWindows/deleteTopic.php', 'ajax'=> true ];
    }


    public function delete(){

        TokenService::check('admin');

        Topic::delete($_POST['topicId']);
        echo json_encode(['success'=>true, 'message'=> topicDeleted()]); exit();
    }

}
  