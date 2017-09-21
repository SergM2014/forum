<h1 class="content-zone__header"><?= $createResponseL ?></h1>
<section class="centered">

    <form action="<?= \Lib\HelperService::currentLang() ?>/admin/response/store" method="post">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">

        <div class="form__field-block">
            <label class="form-field__label" for="topicId"><?= $chooseTopicL ?></label>
            <br>
            <select name="topicId" id="topicId" >
                <?php foreach($topics as $topic): ?>

                    <option value="<?= $topic->id ?>" <?= @$_POST['topicId'] == $topic->id? 'selected': '' ?> ><?=  $topic->title ?></option>

                <?php endforeach ?>
            </select>
        </div>
        

        <div class="form__field-block">
            <label class="form-field__label" id="memberId"><?= $chooseMemberL ?></label>
            <br>
                <select name="memberId" id="memberId">
                <?php foreach($members as $member): ?>
                <option value="<?= $member->id ?>" <?= @$_POST['memberId'] == $member->id? 'selected': '' ?>><?= $member->name ?></option>

                <?php endforeach; ?>
            </select>
        </div>



        <div class="form__field-block">

            <label class="form-field__label" for="response">
                <?= $responseL ?> <br>
            </label>
                <p><textarea name="response" id="response" cols="40" rows="10"><?=  htmlspecialchars(@$_POST['response']) ?></textarea> </p>

                <p><small class="form-field__error"><?= @$errors['response'] ?></small></p>

        </div>




        <div class="form__field-block">
            <p class="form-field__label">
                <?= $taxonomyL ?>
            </p>

            <input type="hidden" name="parentId" id="parentId" value="0">

            <p><label>
                    <input name="parentIdStatus" type="radio" value="0" id="hideTreeStructure"
                                <?= (@$_POST['parentIdStatus'] == 0 OR @!$_POST['parentIdStatus'])? 'checked':'' ?> >
                <?= $designateStartL ?>
            </label></p>

            <p><label>
                    <input name="parentIdStatus" type="radio" value="1" id="showTreeStructure" <?= @$_POST['parentIdStatus']? 'checked':'' ?> >
                    <?= $chooseParentCommentL ?>
            </label></p>

        </div>

        <div class="form__field-block <?= @!$_POST['parentId']? 'hidden': '' ?>" id="chooseParentCommentId">
            This is block where schoosed parent comment id
        </div>


        <label class="form-field__label" >
            <?= $publishedL ?> <br>
            <p><input name="published" type="radio" value="0" <?= @!$_POST['published']? 'checked': '' ?> ><?= $noL ?>
                <input name="published" type="radio" value="1" <?= @$_POST['published'] == '1'? 'checked' : '' ?> ><?= $yesL ?></p>
        </label>

        <br>
        <p>
            <button  type="submit" class="form__button"><?= $addTopicL ?></button>
        </p>

    </form>

</section>

