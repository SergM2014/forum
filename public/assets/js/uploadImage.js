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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ 3:
/***/ (function(module, exports) {


// find repeated values in two arrays
Array.prototype.intersect = function(a){
    return this.filter(function(i){ return a.indexOf(i) > -1;});
};



let progress = document.getElementById('imageDownloadProgress'),
    output = document.getElementById('imageDownloadOutput'),
    submit_btn = document.getElementById('downloadImageBtn'),
    reset_btn = document.getElementById('resetImageBtn'),
    delete_img_sign = document.getElementById('deleteImagePreview'),
    imageField =  document.getElementById('file');

class Helper {
    static getCurrentLang(j){

        let url = window.location.href;
        let urlArray = url.split('/');
        let intersection = urlArray.intersect(j.languagesArray);

        let lang = intersection.shift();
        lang = (lang)? lang : j.defaultLanguage;

        return lang;
    }

    static ucFirst(str) {
        // только пустая строка в логическом контексте даст false
        if (!str) return str;

        return str[0].toUpperCase() + str.slice(1);
    }

}


// this background is for imageupload

function progressHandler(event){

    let percent=Math.round((event.loaded/event.total)*100);

    progress.value = percent;
   // progress.innerText= percent+"%";
}

function completeHandler(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

    let response = JSON.parse(event.target.responseText);
    output.innerHTML= response.message;

    progress.value = 0;
    output.classList.remove('hidden');

    progress.classList.add('hidden');
    reset_btn.removeAttribute('disabled');

    if(!document.getElementById('manyImagesContainer')) {
        submit_btn.classList.add('hidden');
        document.getElementById('imageData').value = (response.image);

        return;
    }

    //further work with many images;

    let imageName = (document.getElementById("file").files[0].name).toLocaleLowerCase();

    let html = `<div class="image-item"><img class="image" src="/uploads/manyItems/${imageName}" alt=""></div>`;
    document.getElementById('manyImagesContainer').insertAdjacentHTML('beforeEnd', html);
    reset_btn.classList.add('hidden');
    submit_btn.classList.add('hidden');
    imageField.classList.remove('hidden');
    imageField.value = '';

    let imageCustomType = document.getElementById('imageCustomType').value;
    let noPhoto = imageCustomType == 'avatar'? 'noavatar' : 'nophoto';

    document.getElementById('downloadImagePreview').setAttribute('src', '/img/'+noPhoto+'.jpg');
    let imagesList = document.getElementById('imageData').value+','+imageName;

    document.getElementById('imageData').value = imagesList;
}


function errorHandler(event){

    output.innerHTML= 'Upload failed';
}


function abortHandler(event){

    output.innerHTML= 'Upload aborted';
}


//to make previe image using file API


if(document.getElementById('file')) {
    document.getElementById('file').onchange = function () {

        if(delete_img_sign) delete_img_sign.className = 'hidden';

        let input = this;

        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('downloadImagePreview').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

                document.getElementById('file').classList.add('hidden');

                output.classList.add('hidden');

                reset_btn.classList.remove('hidden');

                submit_btn.classList.remove('hidden');

            }// else console.log('is not image mime type');
        }// else console.log('not isset files data or files API not supordet');

    };//end of function
}



if(submit_btn){
    submit_btn.onclick = function(e){

        e.preventDefault();
        progress.classList.remove('hidden');


        let file = document.getElementById("file").files[0];

        let formdata = new FormData();
        let _token = document.getElementById('prozessImageToken').value;
        let imageCustomType = document.getElementById('imageCustomType').value;

        formdata.append("file", file);
        formdata.append("_token", _token);
        formdata.append("ajax", true);
        formdata.append("imageCustomType", imageCustomType );



        fetch('/index/getLanguageComponents', {
            'method' : 'POST',
            'credentials' : 'same-origin'
        })
            .then( response => response.json())
            .then(j => {

                let uploadUrl =  "/"+Helper.getCurrentLang(j)+"/images/upload"+Helper.ucFirst(imageCustomType);

                let send_image=new XMLHttpRequest();
                send_image.upload.addEventListener("progress", progressHandler, false);
                send_image.addEventListener("load", completeHandler, false);
                send_image.addEventListener("error", errorHandler, false);
                send_image.addEventListener("abort", abortHandler, false);
                send_image.open("POST", uploadUrl);
                send_image.send(formdata);


                reset_btn.setAttribute('disabled', 'disabled');

            })



    };// end of submit button
}



if(reset_btn) {
    reset_btn.onclick = function (e) {
        e.preventDefault();

        let _token = document.getElementById('prozessImageToken').value;

        let imageCustomType = document.getElementById('imageCustomType').value;
        let noPhoto = imageCustomType == 'avatar'? 'noavatar' : 'nophoto';

        document.getElementById('downloadImagePreview').setAttribute('src', '/img/'+noPhoto+'.jpg');
        document.getElementById('file').classList.remove('hidden');
        let formData = new FormData;
         formData.append('_token', _token);
         formData.append('ajax', true);
         formData.append("imageCustomType", imageCustomType );

         if(document.getElementById('image')) formData.append('image', document.getElementById('image').value);

        fetch('/index/getLanguageComponents', {
            'method' : 'POST',
            'credentials' : 'same-origin'
        })
            .then( response => response.json())
            .then(j =>  "/"+Helper.getCurrentLang(j)+"/images/delete"+Helper.ucFirst(imageCustomType) )
            .then(deleteUrl =>
                                fetch( deleteUrl,
                                    {
                                        method : "POST",
                                        credentials: "same-origin",
                                        body:formData
                                    })
                )

            .then(responce => responce.json())
            .then(j => { output.innerHTML = j.message;
            if(output.classList.contains('hidden')) {
                output.classList.remove('hidden')
            }
            imageField.value = '';

            });



        submit_btn.classList.add('hidden');
        reset_btn.classList.add('hidden');
        if(document.getElementById('imageData')) document.getElementById('imageData').value = '';

    };
}
//end of image reset


if(delete_img_sign){

    document.getElementById('deleteImagePreview').addEventListener('click', function(){

        let _token = document.getElementById('prozessImageToken').value;
        let imageCustomType = document.getElementById('imageCustomType').value;
        let noPhoto = imageCustomType == 'avatar'? 'noavatar' : 'nophoto';
        document.getElementById('downloadImagePreview').setAttribute('src', '/img/'+noPhoto+'.jpg');

        let formData = new FormData;
        formData.append('deleteAvatarInSession', true);
        formData.append('_token', _token);
        formData.append('ajax', true);

        this.className = 'hidden';


        let deleteUrl = "/images/delete"+Helper.ucFirst(imageCustomType);

        fetch( deleteUrl,
            {
                method : "POST",
                credentials: "same-origin",
                body:formData
            })

        imageField.value = '';

    })
}


/***/ })

/******/ });