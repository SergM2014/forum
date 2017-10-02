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


function hideResponseTreeStructure(){
    document.getElementById('chooseParentCommentId').innerHTML = '';
    document.getElementById('chooseParentCommentId').classList.add('hidden');
    document.getElementById('parentId').value = 0;
    document.getElementById('showTreeStructure').checked = false;
    document.getElementById('hideTreeStructure').checked = true;
}


//close alert window
document.getElementById('closeAlert').addEventListener('click', function(){
  hideAlert();
});


document.body.addEventListener('click', function (e) {

        if(e.target.classList.contains('category-item')){

            let categoryId = e.target.dataset.categoryId;

            new PopUpMenu(e).fillUpMenuContent(categoryId, '/showCategoriesPopUp');
        }


        if(e.target.id === 'adminDeleteCategory'){

            PopUpMenu.hideMenu();

            let url = e.target.closest('form').getAttribute('action');

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

                    Modal.removeWindow();
                    document.getElementById('alertZoneText').innerText = json.message;
                    document.getElementById('alertZone').classList.remove('hidden');
                    document.querySelector(`[data-category-id="${categoryId}"] `).remove();
                })
        }


        if(e.target.classList.contains('topic-item')){

            let topicId = e.target.dataset.topicId;

            new PopUpMenu(e).fillUpMenuContent(topicId, '/showTopicsPopUp');

        }

        if(e.target.id === 'adminDeleteTopic'){
            let id = document.getElementById('topicId').value;
            let formData = new FormData;
            formData.append('id', id);
            Modal.createModalWindow('/admin/topic/modalWindow/delete',formData)
        }


    if(e.target.id === 'confirmDelAdmTopic'){

        PopUpMenu.hideMenu();

        let formData = new FormData(document.getElementById('delTopicForm'));
        formData.append('ajax', true);
        let topicId = (formData.get('topicId'));

        fetch(`/admin/topic/${topicId}/delete`, {
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

                Modal.removeWindow();
                document.getElementById('alertZoneText').innerText = json.message;
                document.getElementById('alertZone').classList.remove('hidden');
                document.querySelector(`[data-topic-id="${topicId}"] `).remove();
            })
    }


//click to show popup menu
    if(e.target.closest('.response-item')){

         let responseId = e.target.closest('.response-item').dataset.responseId;

         new PopUpMenu(e).fillUpMenuContent(responseId, '/showResponsesPopUp');
    }


    if(e.target.id === 'showTreeStructure'){
        document.getElementById('chooseParentCommentId').classList.remove('hidden');
        let el = document.getElementById('topicId');
        let id;

        if(el.options){ id = el.options[el.selectedIndex].value; } else {  id = el.value; }


        let formData = new FormData;
        formData.append('id', id);

        if(document.getElementById('responseId')){
            formData.append('responseId', document.getElementById('responseId').value)
        }

        fetch('/admin/response/showTreeStructure', {
            method:'post',
            credentials:'same-origin',
            body:formData
        })
            .then(response => response.text())
            .then(html => document.getElementById('chooseParentCommentId').innerHTML = html )
    }

    if(e.target.id === 'hideTreeStructure'){

       hideResponseTreeStructure()
    }


    if(e.target.closest('.response_item')){

        let responses = document.getElementById('responseStructure').querySelectorAll('.response_item');
        for(let i=0; i<responses.length; i++){
            if(responses[i].classList.contains('choosen-item')){
                responses[i].classList.remove('choosen-item')
            }
        }

        e.target.closest('.response_item').classList.add('choosen-item');
        let id = e.target.closest('.response_item').dataset.responseId;

        document.getElementById('parentId').value = id;
    }



    if(e.target.closest('#topicId')){
        hideResponseTreeStructure();
    }



//click to delete response
    if(e.target.id === 'adminDeleteResponse'){

        PopUpMenu.hideMenu();


        let formData = new FormData(document.getElementById('adminDeleteResponseForm'));

        Modal.createModalWindow('/admin/response/modalWindow/delete', formData);

    }


    if(e.target.id === 'confirmDelAdmResponse'){

        PopUpMenu.hideMenu();

        let formData = new FormData(document.getElementById('delResponseForm'));
        formData.append('ajax', true);
        let responseId = (formData.get('responseId'));

        fetch(`/admin/response/${responseId}/delete`, {
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

                Modal.removeWindow();
                document.getElementById('alertZoneText').innerText = json.message;
                document.getElementById('alertZone').classList.remove('hidden');
                document.querySelector(`[data-response-id="${responseId}"] `).remove();
            })
    }

//member section
    if(e.target.closest('.member_item')){

        let memberId = e.target.closest('.member_item').dataset.memberId;

        new PopUpMenu(e).fillUpMenuContent(memberId, '/showMembersPopUp');

    }


    if(e.target.id === 'adminDeleteMember'){

        PopUpMenu.hideMenu();


        let formData = new FormData(document.getElementById('adminDeleteMemberForm'));

        Modal.createModalWindow('/admin/members/modalWindow/delete', formData);

    }


    if(e.target.id === 'confirmDelAdmMember'){

        PopUpMenu.hideMenu();

        let formData = new FormData(document.getElementById('delMemberForm'));
        formData.append('ajax', true);
        let memberId = (formData.get('memberId'));

        fetch(`/admin/members/${memberId}/delete`, {
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

                Modal.removeWindow();
                document.getElementById('alertZoneText').innerText = json.message;
                document.getElementById('alertZone').classList.remove('hidden');
                document.querySelector(`[data-member-id="${memberId}"] `).remove();
            })
    }


    });

//hide popup menu at click of outside the table
document.getElementsByClassName('container')[0].addEventListener('click', function (e) {
    if( document.getElementById('popupMenu')){

      PopUpMenu.hideMenu();
     }
     if(!document.getElementById('alertZone').classList.contains('hidden')){
         document.getElementById('alertZone').classList.add('hidden');
     }
});













