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




});//ends of events that are hanged on the body



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





if(document.getElementById('manyImagesContainer')){
    var el = document.getElementById('manyImagesContainer');
    var sortable = Sortable.create(el, {
        onEnd: function () {

           refreshImageDataField();
        },
    });
}














