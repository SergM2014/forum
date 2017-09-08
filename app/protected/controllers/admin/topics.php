<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Topic;
use App\Models\Category;
use Lib\TokenService;
use App\Models\CheckForm;
use App\Models\Member;

use App\Models\Index;

use function categoryHasChildren;
use function categoryDeleted;

class Admintopics  extends AdminController {

    public function __construct()
    {
        //if(@$_SESSION['admin']['upgrading_status']!= 3) exit('Unathoriraised access!');
        parent::__construct();
    }


    public function index()
    {
        $topics = Topic::getAllTopics();
        return ['view' => 'views/admin/topics/index.php', 'topics' => $topics];
    }

    public function create($errors = null)
    {
       $categoryDropDownList = (new Category)->getCategoryDropDownTree();
//get members List
        $members = Member::getAllMembers();

        $_SESSION['createTopic'] = true;
       return ['view' => 'views/admin/topics/create.php', 'categoryDropDownList' => $categoryDropDownList,
           'members' => $members, 'errors' => $errors];

    }

    public function store()
    {
        TokenService::check('admin');

        if(@!$_SESSION['createTopic']) return $this->create();

        $cleanedUpInputs = self::escapeInputs('title');
        $errors = CheckForm::checkCreateTopicForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->create($errors);
        };

        Topic::store($cleanedUpInputs);

        unset($_SESSION['createTopic']);

        return ['view'=>'views/admin/topics/stored.php' ];
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
        return ['view'=>'views/admin/modalWindows/deleteCategory.php', 'ajax'=> true ];
    }


    public function delete(){

        TokenService::check('admin');
//chek if category has child categories
       if( Category::hasChildren($_POST['categoryId'])){
           echo json_encode(['hasChildren' => true, 'message' => categoryHasChildren() ]); exit();
       }
        Category::delete($_POST['categoryId']);
        echo json_encode(['success'=>true, 'message'=> categoryDeleted()]); exit();
    }

}
  