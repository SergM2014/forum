<section class="responses_list">

    <ul>
        <?= $topicResponses ?>
    </ul>

</section>

<a name="parentComment"></a>
<div id="parentComment" class="parent-comment"></div>

<section class="add_response centered" id="addResponseBlock">



    <h1 class="main-header__h1">Add Response</h1>


    <form action="<?= \Lib\HelperService::currentLang() ?>/" id="addCommentForm" method="post" >
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
        <input type="hidden" name="topicId" id="topicId" value="<?= $id ?>">
        <input type="hidden" name="parentId" id="parentId" value="0">



        <div class="subscribtion-form__field-block">
            <label class="form-field__label" for="comment"><?= $commentL ?></label> <br>
                <textarea name="comment" id="comment" rows="10" cols="40" class="input-field"></textarea>
                <p><small id="commentError" class="error"></small></p>
        </div>

        <p>
            <button type="button" class="subscribtion-form__button" id="addCommentSubmitBtn"><?= $addCommentL ?></button>
        </p>
    </form>



</section>

