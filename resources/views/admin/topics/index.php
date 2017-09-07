<h1 class="h1">This is topics</h1>

<section class="centered">
    <ul class="list">
        <?php foreach($topics as $topic): ?>

            <li><span class="topic-item hover" data-topic-id="<?= $topic->id ?>"><?= $topic->title ?></span></li>

        <?php endforeach ?>
    </ul>
</section>
