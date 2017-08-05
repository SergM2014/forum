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