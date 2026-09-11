<?php
if (isset($showParent) && $showParent  == 'yes') {
    $page = $page->parent();
}

$examples = $page->content_examples()->toStructure();
if (isset($examples) && $examples->count() > 0): ?>

    <div class="example">
        <?php foreach ($examples as $example): ?>

            <div class="f-row">
                <div class="f-col">
                    <h2 class="example__title"><?= $example->content_text_pre()->text() ?></h2>
                    <?php if ($imagePre = $page->image($example->content_img_pre())): ?>
                        <p class="example__desc"><img class="example__img" alt="<?= $example->content_text_pre()->text() ?>" title="<?= $example->content_text_pre()->text() ?>" src="<?= $imagePre->url() ?>"></p>

                    <?php endif ?>
                </div>
                <div class="f-col">
                    <h2 class="example__title"><?= $example->content_text_after()->text() ?></h2>
                    <?php if ($imageAfter = $page->image($example->content_img_after())): ?>
                        <p class="example__desc"><img class="example__img" alt="<?= $example->content_text_after()->text() ?>" title="<?= $example->content_text_after()->text() ?>" src="<?= $imageAfter->url() ?>"></p>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>

    <?php if(!$page->content_text_pre()->empty()): ?>

        <div class="example">

            <div class="f-row">
                <div class="f-col">
                    <h2 class="example__title"><?= $page->content_text_pre()->text() ?></h2>
                    <?php if ($imagePre = $page->image($page->content_img_pre())): ?>
                        <p class="example__desc"><img class="example__img" alt="<?= $page->content_text_pre()->text() ?>" title="<?= $page->content_text_pre()->text() ?>" src="<?= $imagePre->url() ?>"></p>

                    <?php endif ?>
                </div>
                <div class="f-col">
                    <h2 class="example__title"><?= $page->content_text_after()->text() ?></h2>
                    <?php if ($imageAfter = $page->image($page->content_img_after())): ?>
                        <p class="example__desc"><img class="example__img" alt="<?= $page->content_text_after()->text() ?>" title="<?= $page->content_text_after()->text() ?>" src="<?= $imageAfter->url() ?>"></p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php endif ?>

<?php endif ?>

<?php if(!$page->content_video_description()->empty()): ?>
    <div class="cont-html">
        <?= $page->content_video_description()->kirbytext() ?>
    </div>
<?php endif ?>
<?php if($page->hasVideos()): ?>
    <?php
    // fetch all video formats we need
    snippet('/shared/video', array(
        'text' =>$page->content_video_text()->text(),
        'videos' => $page->videos()
    ));
    ?>
<?php endif ?>


