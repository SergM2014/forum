<?php
namespace App\Core\HihgLevelDependacy;

use Lib\HelperService;
/**
 * the router class due to the url choose the appropriate controller
 * Class MainDispatcher
 * @package App\Core\Upper
 */
abstract class MainDispatcher
 {

    public $url;


    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];

    }



    /**
     * get the url-path, defines controller itself and its action + 404 redirection
     * @return array
     */


    function getController($routes){
//var_dump($this->url);
        $givenUrl = trim($this->url);
        $givenUrl = trim($givenUrl,'/');

        $controller = new \stdClass;

        foreach ( $routes as $key => $value){
            $route = trim($key, '/');
            $route = '~^'.$route.'$~';

            $pattern = preg_replace('/\{\w+\}/', '\w+', $route);
//var_dump($givenUrl);
//var_dump($pattern);
//if route coinceides with given Url
            if(preg_match($pattern, $givenUrl)){

                $controller->controller = strtolower($value);
//var_dump($controller->controller);
//if arguments are present in the route
                if( preg_match('~\{\w+\}~', $route)){

                    $array = explode('/' , $route);

                    $positions = [];
                    foreach ($array as $key => $value){
                        if(preg_match('~\{\w+\}~', $value)) $positions[]= $key;
                    }

                    $arguments = [];
                    $urlArray = explode('/', $givenUrl);

                    foreach ($positions as $position){
                        $arguments[] = $urlArray[$position];
                    }

                    $controller->arguments = $arguments;
                }
                
            }
        }

        $controller->controller = $controller->controller ?? '404@index';

        $givenController = explode('@', $controller->controller );

        $class = '\App\Controllers\\';

        if(
            !class_exists($class.ucfirst($givenController[0])) OR
            !method_exists($class.ucfirst($givenController[0]), $givenController[1] )
        )
            {
                $givenController[0] = 'error_404'; $givenController[1] = 'index';
            }

        $givenController['arguments'] = $controller->arguments?? null;

        return $givenController;
    }







    /**
     *
     * liquidate GET variable from URL
     * @return string
     */
	private function getRidOfGET()
	{
        $url = trim($this->url, '/');
//cast information after &
		if(stripos($url, '?')!== false){ $url = explode('?', $url);   $url= $url[0];}
        $this->url = $url;
	}


    /**
     * get free from language component url and language component itself
     * @param $url
     * @return array|string
     */


    protected function getLanguageComponent()
    {
//var_dump($this->url);
        $url = $this->url;
        //if string to explode then explode into array
        if(strripos($url, '/')!== false ) {
            $url = explode('/', $url); $lang= $url[0];
        }
        //if this is just a string
        if(is_string($url)){ $lang = $url;}

        $langs = HelperService::prozessLangArray();

        //check if the posible language is present in Language list
        if (array_key_exists($lang, $langs)){
            $currentLang = $lang;
            //make url cleaner
            if(is_string($url)) $url='';
            if(is_array($url)) {
                array_shift($url);
                if(count($url)==1) { $url= $url[0]; }
            }
        }
        else {
            $currentLang = DEFAULT_LANG;
        }

        if(is_array($url)){
            $this->url = implode('/',$url);
        }


        return $currentLang;
    }

    /**
     * get Language component from Url
     * @return array|string
     */
    public function getCurrentLanguage()
    {
        $this->getRidOfGET();

        $currentLang =  $this->getLanguageComponent();

        return $currentLang;
    }



    /**
     *
     * fire of a controller
     * @param $controller
     * @return mixed
     */
    abstract function runController($controller);

    /**
     *
     * get Path to view layout
     * @param $view
     * @return mixed
     */
    abstract function getView($view);

 }
 
 
?>
