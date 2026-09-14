<?php /** Generieke pagina (o.a. portfolio). $page, $crumbs */
$mediaBase = $page['media_dir'] ?? '';
?>
<section class="article-02">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php view('breadcrumb', ['crumbs' => $crumbs]); ?>
                <div class="article-02__content">
                    <div class="cont-html">
                        <h1 class="lane__title"><?= h($page['intro_title']) ?></h1>
                        <?= ktext($page['intro_description']) ?>
                        <?= ktext($page['content_description'] ?? '') ?>
                    </div>

                    <?php if (!empty($page['content_img_pre'])): ?>
                        <div class="example">
                            <div class="f-row">
                                <div class="f-col">
                                    <h2 class="example__title">Voorbeeld <?= h($page['content_text_pre'] ?? '1') ?></h2>
                                    <?php if (file_exists(MEDIA_DIR . '/' . $mediaBase . '/' . $page['content_img_pre'])): ?>
                                        <p class="example__desc"><img class="example__img" loading="lazy" alt="Voorbeeld" src="/media/<?= h($mediaBase) ?>/<?= h($page['content_img_pre']) ?>"></p>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($page['content_img_after'])): ?>
                                <div class="f-col">
                                    <h2 class="example__title">Voorbeeld <?= h($page['content_text_after'] ?? '2') ?></h2>
                                    <?php if (file_exists(MEDIA_DIR . '/' . $mediaBase . '/' . $page['content_img_after'])): ?>
                                        <p class="example__desc"><img class="example__img" loading="lazy" alt="Voorbeeld" src="/media/<?= h($mediaBase) ?>/<?= h($page['content_img_after']) ?>"></p>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (($page['enable_contact'] ?? '0') === '1'): ?>
                        <?php view('group_communication'); ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="article-02__col-2">
                <div class="article-02__box">
                    <?php view('sidebar', ['showWhy' => true]); ?>
                </div>
            </div>
        </div>
    </div>
</section>
