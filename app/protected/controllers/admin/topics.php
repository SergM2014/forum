<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Topic;
use App\Models\Category;
use Lib\TokenService;
use App\Models\CheckForm;
use App\Models\Member;


use function topicDeleted;

class AdminTopics  extends AdminController {

    public function index()
    {
        $topics = Topic::getAllTopics();

        return ['view' => 'views/admin/topics/index.php', 'topics' => $topics];
    }

    public function create($errors = null)
    {
       $categoryDropDownList = (new Category)->getCategoryDropDownTree();

        $members = Member::getAllMembers();

        $this->setReferrer('createTopic');

       return ['view' => 'views/admin/topics/create.php', 'categoryDropDownList' => $categoryDropDownList,
           'members' => $members, 'errors' => $errors];

    }

    public function store()
    {
        $this->checkReferrer('createTopic');

        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('title');
        $errors = CheckForm::checkCreateTopicForm($cleanedUpInputs);


        if(!empty($errors)) {
            return $this->create($errors);
        };

        Topic::store($cleanedUpInputs);

        return ['view'=>'views/admin/completedAction.php', 'action'=>'topicCreatedL' ];
    }


    public function edit($id,$errors = null)
    {
        $topic = Topic::getOneTopic($id);

        $selectedCategory = $_POST['categoryId']?? $topic->category_id;

        $categoryDropDownList = (new Category)->getCategoryDropDownTree($selectedCategory);

        $members = Member::getAllMembers();

        $this->setReferrer('updateTopic');

        return ['view' => 'views/admin/topics/edit.php', 'categoryDropDownList' => $categoryDropDownList, 'id'=> $id,
            'categoryId' => $id, 'title' => $topic->title, 'members' => $members, 'memberId' => $topic->member_id,
            'errors' => $errors];

    }

    public function update($id)
    {
        $this->checkReferrer('updateTopic');

        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('title');

        $errors = CheckForm::checkUpdateCategoryForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->edit($id, $errors);
        };

        Topic::update($id,$cleanedUpInputs);

        return ['view'=>'views/admin/completedAction.php', 'action'=>'topicUpdatedL' ];
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
  