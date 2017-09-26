<h1 class="content-zone__header"><?= $updateResponseL ?></h1>
<section class="centered">

    <form action="<?= \Lib\HelperService::currentLang() ?>/admin/response/<?= $id ?>/update" method="post">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">

        <div>
            <p>
                <?= $topicL ?>
                <span class="red"><?= $response->topic_title ?></span>
            </p>
        </div>


        <div>
            <?php if($response->avatar): ?>

                <img src="<?= $response->avatar ?>" alt='' class='response-item__avatar'>

            <?php endif; ?>
            <p>
                <?= $memberL ?>
                 <span class="red"><?= $response->member_name ?></span>
            </p>
        </div>



        <div class="form__field-block">

            <label class="form-field__label" for="response">
                <?= $responseL ?> <br>
            </label>
            <p><textarea name="response" id="response" cols="40" rows="10"><?=  isset($_POST['response'])? htmlspecialchars($_POST['response']): $response->response ?></textarea> </p>

            <p><small class="form-field__error"><?= @$errors['response'] ?></small></p>

        </div>




        <div class="form__field-block">
            <p class="form-field__label">
                <?= $taxonomyL ?>
            </p>

            <input type="hidden" name="parentId" id="parentId" value="<?= $_POST['parentId']?? $response->parent_id ?>">
            <input type="hidden" name="topicId" id="topicId" value="<?= $_POST['topicId']?? $response->topic_id ?>" >
            <input type="hidden" name="responseId" id="responseId" value="<?= $id ?>" >

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
            <?php $published = $_POST['published']?? $response->published ?>
            <?= $publishedL ?> <br>
            <p><input name="published" type="radio" value="0" <?= $published == 0 ? 'checked': '' ?> ><?= $noL ?>
                <input name="published" type="radio" value="1" <?= $published == 1 ? 'checked' : '' ?> ><?= $yesL ?></p>
        </label>

        <br>
        <p>
            <button  type="submit" class="form__button"><?= $updateL ?></button>
        </p>

    </form>

</section>

