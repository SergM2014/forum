<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Member;
use App\Models\Topic;
use Lib\TokenService;
use App\Models\CheckForm;





use function responseDeleted;

class Adminmembers  extends AdminController {

    public function index()
    {
        $pages = Member::countMemberPages();
        $members = Member::getAllMembers();
        $counter = Member::getTableCounter($pages);


        return ['view' => 'views/admin/members/index.php', 'members' => $members, 'pages' =>$pages, 'counter' =>$counter];
    }

    public function create($errors = null)
    {
        $_SESSION['createMember'] = true;
       return ['view' => 'views/admin/members/create.php', 'errors' => $errors];

    }


    public function store()
    {
        TokenService::check('admin');

        if(@!$_SESSION['createMember']) return $this->create();

        $cleanedUpInputs = self::escapeInputs('name', 'email', 'password');

        $errors = CheckForm::checkRegisterMemberForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->create($errors);
        };

        Member::persistMember($cleanedUpInputs);

        unset($_SESSION['createMember']);

        return ['view'=>'views/admin/members/stored.php' ];
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
  