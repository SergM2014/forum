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

        extract($this->siteStatistic());

        return ['view'=>'views/common/index.php', 'result' => $result, 'visitorsOnline' => $visitorsOnline,
            'responsesAmount'=> $responsesAmount, 'membersOnline'=> $membersOnline, 'lastMemberName'=> $lastMemberName,
            'membersAmount'=> $membersAmount];
    }




   public function category($title)
   {
       $categoryTopics = (new Model())->getOneCategoryGeneralInfo($title);

      extract($this->siteStatistic());

       return ['view'=>'views/common/category.php', 'categoryTopics' => $categoryTopics, 'visitorsOnline' => $visitorsOnline,
           'responsesAmount'=> $responsesAmount, 'membersOnline'=> $membersOnline, 'lastMemberName'=> $lastMemberName,
           'membersAmount'=> $membersAmount];



   }

    private function siteStatistic()
    {
        $visitorsOnline = Background::visitorsOnline();
        $membersOnline = Background::membersOnline();
        $responsesAmount = Background::responsesAmount();
        $lastMemberName = Background::lastRegisteredMember();
        $membersAmount = Background::membersAmount();

        return compact('visitorsOnline', 'membersOnline', 'responsesAmount', 'lastMemberName', 'membersAmount');
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

      public function getCaptchaOutput()
      {
          return ['view'=>'views/common/partials/captcha.php', 'ajax'=>true];
      }








  }
  