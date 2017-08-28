/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */,
/* 1 */
/***/ (function(module, exports) {

let languageCached;
let popupMenuSaved;
Array.prototype.intersect = function(a){
    return this.filter(function(i){ return a.indexOf(i) > -1;});
};


class LanguageHelper {

    static getCurrentLang(languagesSettings) {

        let url = window.location.href;
        let urlArray = url.split('/');
        let intersection = urlArray.intersect(languagesSettings.languagesArray);

        let lang = intersection.shift();
        return (lang) ? lang : languagesSettings.defaultLanguage;
    }


    /**
     * getLanguagesSettings
     *
     * @returns {Promise.<TResult>}
     */
    static getLanguagesSettings() {

        if(languageCached) return languageCached;

        return fetch('/index/getLanguageComponents', {
            'method': 'POST',
            'credentials': 'same-origin'
        })
            .then(response => { languageCached =  response.json(); return languageCached; });


    }
}

/**
 * wraper for ajax request based on fetch
 *
 * @param givenUrl
 * @param formData
 * @param cache
 * @returns {Promise.<TResult>}
 */
function postAjax(givenUrl, formData){

   /* if(!formData)
        let formData = new FormData;


    formData.append('ajax', true );*/


    let queryResult =   LanguageHelper.getLanguagesSettings()
        .then(languagesSettings => {

            let url = "/" + LanguageHelper.getCurrentLang(languagesSettings) + givenUrl;

            return   fetch(
                url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData

                })
        });

    return queryResult;
    }

function hideAlert(){
    document.getElementById('alertZone').classList.add('hidden');
    document.getElementById('alertZoneText').innerText = '';
}

function showAlert(message){
    document.getElementById('alertZone').classList.remove('hidden');
    document.getElementById('alertZoneText').innerText = message;
}



class PopUpMenu{
    constructor(e){
        this.x = e.pageX;
        this.y = e.pageY;

        this.screenWidth = document.body.clientWidth;
        this.screenHeight = document.body.clientHeight;
        this.target = e.target;
    }


    drawMenu(x = 100, y = 60){

        if(popupMenuSaved && document.getElementById('popupMenu')){
            this.popUp = document.getElementById('popupMenu');
            this.popUp.classList.remove('hidden')
        } else {

            this.popUp = document.createElement('div');
            this.popUp.className = "popup-menu";
            this.popUp.id = "popupMenu";

            document.body.insertBefore(this.popUp, document.body.firstChild);
        }



        if(this.x+x >this.screenWidth+pageXOffset) this.x= (this.screenWidth+pageXOffset-x);
        if(this.y+y >this.screenHeight+pageYOffset) this.y= (this.screenHeight+pageYOffset-y);

        this.popUp.style.left = this.x+"px";
        this.popUp.style.top = this.y+"px";
    }

    static deleteMenu()
    {
        if(document.getElementById('popupMenu')){document.getElementById('popupMenu').remove();}
    }


    fillUpMenuContent(id, popUpContr, processContr = ''){
       this.drawMenu();


        let formData = new FormData;
        formData.append('id', id);
        formData.append('processContr', processContr);

        postAjax(popUpContr,formData)
            .then(response => { popupMenuSaved = true; return response.text(); })
            .then(html =>document.getElementById('popupMenu').innerHTML= html);
    }

    static hideMenu()
    {
        if(document.getElementById('popupMenu')){
            document.getElementById('popupMenu').classList.add('hidden');


        }
    }


}

class Modal {
    static createBackground() {
        let background = document.createElement('div');
        background.className = "modal-background";
        background.id = "modalBackground";
        document.body.insertBefore(background, document.body.firstChild);
    }

    static createModalWindow(route, formData){
        this.createBackground();
        postAjax(route, formData)
             .then(response => response.text())
            .then(html =>document.getElementById('modalBackground').insertAdjacentHTML('afterBegin', html));
    }

    static removeWindow(){
        document.getElementById('modalBackground').remove();

    }


}


//close alert window
document.getElementById('closeAlert').addEventListener('click', function(){
  hideAlert();
});


document.body.addEventListener('click', function (e) {

        if(e.target.classList.contains('category-item')){

            // let formData = new FormData();
            let categoryId = e.target.dataset.categoryId;
            // formData.append('categoryId', categoryId);


            new PopUpMenu(e).fillUpMenuContent(categoryId, '/showCategoriesPopUp');

        }


        if(e.target.id === 'adminDeleteCategory'){

            PopUpMenu.hideMenu();

            let url = e.target.closest('form').getAttribute('action');
            //console.log(url);
            let formData = new FormData(document.getElementById('adminDeleteCategoryForm'));

            Modal.createModalWindow('/admin/category/modalWindow/delete', formData);

        }



//close modal warning window
        if(e.target.id === 'canselBtn'){
           Modal.removeWindow();
        }


        if(e.target.id === 'confirmDelAdmCategory'){
            let formData = new FormData(document.getElementById('delCatForm'));
            formData.append('ajax', true);
            let categoryId = (formData.get('categoryId'));
            fetch(`/admin/category/${categoryId}/delete`, {
                method:'post',
                credentials:'same-origin',
                body:formData
            })
                .then(response => response.json())
                .then(json => {
                    if(json.hasChildren){
                        Modal.removeWindow();
                        document.getElementById('alertZoneText').innerText = json.message;
                        document.getElementById('alertZone').classList.remove('hidden');
                    }
//console.log(json)
//success, remove modal window, remove category in main list output, print out the message with success
                    Modal.removeWindow();
                    document.getElementById('alertZoneText').innerText = json.message;
                    document.getElementById('alertZone').classList.remove('hidden');
                    document.querySelector(`[data-category-id="${categoryId}"] `).remove();
                })
        }

    });

//hide popup menu
document.getElementsByClassName('container')[0].addEventListener('click', function (e) {
    if( document.getElementById('popupMenu')){

      PopUpMenu.hideMenu();
     }
     if(!document.getElementById('alertZone').classList.contains('hidden')){
         document.getElementById('alertZone').classList.add('hidden');
     }
});










/***/ })
/******/ ]);