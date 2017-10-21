<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Member;
use Lib\TokenService;
use App\Models\CheckForm;


use function memberDeleted;



class AdminMembers  extends AdminController {



    public function __construct()
    {
        parent::__construct();

        $this->checkAdminLevel(2);
    }

    public function index()
    {
        $pages = Member::countMemberPages();

        $members = Member::getAdminAllMembers($pages);

        $counter = Member::getTableCounter($pages);

        return ['view' => 'views/admin/members/index.php', 'members' => $members, 'pages' =>$pages, 'counter' =>$counter];
    }

    public function create($errors = null)
    {
        $this->setReferrer('createMember');

       return ['view' => 'views/admin/members/create.php', 'errors' => $errors];

    }


    public function store()
    {
        $this->checkReferrer('createMember');
        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('name', 'email', 'password');

        $errors = CheckForm::checkRegisterMemberForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->create($errors);
        };

        Member::persistMember($cleanedUpInputs);

        return ['view'=>'views/admin/completedAction.php', 'action' => 'newMemberSavedL' ];
    }


    public function edit($id,$errors = null)
    {
        $member = Member::getMember($id);

        $this->setReferrer('editMember');

        return ['view' => 'views/admin/members/edit.php', 'member' => $member, 'id' =>$id,
            'errors' => $errors ];

    }

    public function update($id)
    {
        $this->checkReferrer('editMember');

        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('name', 'email', 'password');
        $errors = CheckForm::checkUpdateMemberForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->edit($id, $errors);
        };

        Member::adminUpdate($id,$cleanedUpInputs);

        return ['view'=>'views/admin/completedAction.php', 'action' => 'memberUpdatedSuccessfullyL' ];
    }

    public function modalWindowDelete()
    {
        return ['view'=>'views/admin/modalWindows/deleteMember.php', 'ajax'=> true ];
    }


    public function delete($id){

        TokenService::check('admin');

         Member::deleteMember($id);
        echo json_encode(['success'=>true, 'message'=> memberDeleted()]); exit();
    }

}
  