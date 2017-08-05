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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

document.getElementById('mainHeaderSearchField').addEventListener('keyup', function(e){

    let form = new FormData;

    let searchValue = document.getElementById('mainHeaderSearchField').value;

    if(searchValue.length <1) {

        if(document.getElementById('searchResultsBlock')){
            document.getElementById('searchResultsBlock').remove();
        }
    }

    if(searchValue.length<4) return;

    if(!document.getElementById('searchResultsBlock')){
        let searchBlock = document.createElement('div');
        searchBlock.className = 'search-results-container';
        searchBlock.id = 'searchResultsBlock';
        document.getElementById('mainHeaderSearchContainer').append(searchBlock);
    }


    form.append('searchValue', searchValue);

    fetch('/searchResults',{
        method:'POST',
        credentials:'same-origin',
        body:form
    })
        .then(response => response.text())
        .then(html =>{
            document.getElementById('searchResultsBlock').innerHTML = html;
        })
});

document.body.addEventListener('click', function(e){

    if(e.target.closest !== 'mainHeaderSearchContainer'){
        if(document.getElementById('searchResultsBlock')){
            document.getElementById('searchResultsBlock').remove();
        }
    }

});

/***/ }),
/* 1 */,
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(0);

//return intersection of two files
Array.prototype.intersect = function(a){
    return this.filter(function(i){ return a.indexOf(i) > -1;});
};

function refreshImageDataField(){
    let all = document.querySelectorAll('.image');
    let images =[];
    for (let i=0; i < all.length; i++){
        images.push(all[i].dataset.image);
    }
    document.getElementById('imageData').value = images;

}

let languagesBox = document.getElementsByClassName('main-header__language-select')[0];


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

        return fetch('/index/getLanguageComponents', {
            'method': 'POST',
            'credentials': 'same-origin'
        })
            .then(response => response.json());


    }
}

    /**
     * returns ajax request according to current language on site
     *
     * @param givenUrl
     * @param formData
     * @returns {Promise.<TResult>}
     */
    function postAjax(givenUrl, formData){

       if(!formData){
           let formData = new FormData;
           formData.append('ajax', true );
       }

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







//toggle languages in the header
languagesBox.addEventListener('click', function(){
    document.getElementsByClassName('main-header__language-select-dropdown')[0].classList.toggle('hidden')
});



document.body.addEventListener('click', function(e){

    if(e.target.className === "image"){
        let confirmation = confirm('realy to del message?');

        if(confirmation){
           e.target.closest('.image-item').remove();
           refreshImageDataField();
        }
    }

    if(e.target.closest('#captchaImgContainer')){

        let form = new FormData();
        form.append('ajax', true);
        fetch('/getCaptcha',{
            method:'POST',
            body:form,
            credentials:'same-origin'
        })
            .then(response => response.text())
            .then(html => document.getElementById('captchaImgContainer').innerHTML = html )
            .catch(error => console.log(error))
    }

    if(e.target.id === "addCommentSubmitBtn"){
        let form = new FormData(document.getElementById('addCommentForm'));

        fetch('/addResponse', {
            body:form,
            method:'POST',
            credentials:'same-origin'
        })
            .then(response => response.json())
            .then(json => {
                if(json.error) throw json;
//here are the action related to success
                document.getElementById('addResponseBlock').innerHTML ='Greetings!!! Your comment will be published imidiatly';
            })
            .catch(error =>{
//populate errors fields
//clearfy all error inputs
                let errorInputs = document.getElementById('addCommentForm').querySelectorAll('.error');
                for(let i=0; i< errorInputs.length; i++){
                    errorInputs[i].innerText = '';
                }
//populate error field with errors
                for (let key in error) {
                    if(key === "error") continue;
                    document.getElementById(key+'Error').innerText = error[key];
                }
            });
    }

//click response btn of selected comment and showing it for comment
    if(e.target.className === 'response_answer-btn'){

        let id = e.target.dataset.responseId;

        let form = new FormData;
        form.append('id', id);
        fetch('/showParentComment', {
            body:form,
            method:'POST',
            credentials:'same-origin'
        })
            .then(response => response.text())
            .then(html => {
                document.getElementById('parentComment').innerHTML = html;
                document.getElementById('parentId').value = id;
            } )
            .catch(error =>console.log(error))

    }
//close parent comment that should be responded
    if(e.target.id === 'parentCommentCloseSign'){
        document.getElementById('parentComment').innerHTML = '';
        document.getElementById('parentId').value = 0;
    }


    // if(e.target.id === "addCommentSubmitBtn"){
    //     alert (1111)
    // }


});//ends of events that are hanged on the body





//remove errors from input fields making keydown on them
if(document.getElementById('addCommentForm')){
    document.getElementById('addCommentForm').addEventListener('keydown', function(e){
        e.target.closest('div').querySelector('.error').innerText ='';
    });
}






document.getElementById('mainHeaderTouchBtn').addEventListener('click', function(){

    document.getElementById('mainHeaderMenu').classList.add('show-menu');
    setTimeout(function() {  document.getElementById('mainHeaderMenu').classList.add('menu_is_shown') }, 2000)



});


if(document.documentElement.clientWidth < 751){
    document.addEventListener('click', function(e){
        if ( !e.target.closest('#mainHeaderTouchBtn') && !e.target.closest('#mainHeaderMenu')){

            document.getElementById('mainHeaderMenu').className = "main-header__menu"

        }
    })
}


















/***/ })
/******/ ]);