<?php

namespace App\Controllers;



use App\Core\BaseController;

use Lib\TokenService;
use Lib\CheckFieldsService;

use App\Models\CheckForm;
use App\Models\Member as MemberModel;
use App\Controllers\Index;




class Member  extends BaseController
  {

    use CheckFieldsService;


    public function register($errors = null)
	{
        $_SESSION['createMember']= true;
        return ['view'=>'views/common/member/registerForm.php', 'errors'=> $errors];
    }

//save new created member
    public function store()
    {
        if(@!$_SESSION['createMember']) return $this->register();
        TokenService::check('user');
        $cleanedUpInputs = self::escapeInputs('name', 'email', 'password', 'password2');
        $errors = CheckForm::checkRegisterMemberForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
           return $this->register($errors);
        };

        MemberModel::persistMember($cleanedUpInputs);

        unset($_SESSION['createMember']);

        return $this->memberCreated();

    }

    public function memberCreated()
    {

       return ['view'=>'views/common/member/savedNewMember.php'];
    }

    public function signIn($loginError = null)
    {
        $_SESSION['memberSignIn'] = true;
       return ['view' => 'views/common/member/signIn.php', 'loginError' => $loginError];
    }

    public function getMember()
    {
        if(@!$_SESSION['memberSignIn']) return $this->signIn();
        TokenService::check('user');

        unset($_SESSION['memberSignIn']);
       if(!MemberModel::login()) return $this->signIn($loginError = true);

        return  ['view' => 'views/common/member/loginSucceeded.php'];
    }

    public function signOut()
    {
        unset($_SESSION['member']);

        return (new Index())->index();
    }

    public function edit($memberName, $errors = null )
    {
        if(@!$memberName){
            exit('no member name!!!');
        }
       $member = MemberModel::getMember($memberName);

       $_SESSION['updateMember'] = true;

       return ['view'=> 'views/common/member/edit.php', 'member'=> $member, 'errors' => $errors, 'memberName'=>$memberName ];
    }


    public function update()
    {
        if(@!$_SESSION['updateMember']) return $this->edit($_POST['memberName']);
        TokenService::check('user');
        $cleanedUpInputs = self::escapeInputs('name', 'email', 'password', 'password2');
        $errors = CheckForm::checkUpdateMemberForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) { return $this->edit($_POST['memberName'],$errors); };

        unset($_SESSION['updateMember']);
        MemberModel::update($cleanedUpInputs);

        return ['view'=> 'views/common/member/updateSucceeded.php'];
    }















  }
  