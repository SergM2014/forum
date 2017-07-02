<?php

namespace App\Controllers;



use App\Core\BaseController;

use App\Models\Background;
use Lib\HelperService;
use Lib\CheckFieldsService;
use App\Models\Index as Model;
use App\Models\CheckForm;
use Lib\Visitors;



class Index  extends BaseController
  {

    use CheckFieldsService;
      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{
	    $result = (new Model())->getCategoryTableTree();
	    $visitorsOnline = Background::visitorsOnline();
	    $membersOnline = Background::membersOnline();
	    $responsesAmount = Background::responsesAmount();
	    $lastMemberName = Background::lastRegisteredMember();
	    $membersAmount = Background::membersAmount();
        return ['view'=>'views/common/index.php', 'result' => $result, 'visitorsOnline' => $visitorsOnline,
            'responsesAmount'=> $responsesAmount, 'membersOnline'=> $membersOnline, 'lastMemberName'=> $lastMemberName,
            'membersAmount'=> $membersAmount];
    }

    public function edit($errors = null )
    {
        $user = Model::getUser();
        $this->setReferrer('edit');

        return ['view'=>'views/common/edit.php', 'user'=>$user, 'errors'=> $errors];
    }

    public function update()
    {
        $this->checkReferrer('edit');

        $cleanedUpInputs = self::escapeInputs('login', 'email');
        $errors = CheckForm::checkForm($cleanedUpInputs);
        if(!empty($errors)) return $this->edit($errors);
        Model::updateUser($cleanedUpInputs);
        exit('this is update controller having work further');
    }





    /**
     * represent default language and array of given languages from config in json format
     */
      public function getLanguageComponents()
      {
          $langs = array_keys( HelperService::prozessLangArray());

          echo json_encode(['defaultLanguage' => DEFAULT_LANG, 'languagesArray' => $langs]);
          exit();
      }


      public function showArgs($arg1, $arg2)
      {
        var_dump($arg1);
        dd($arg2);
      }





  }
  