<?php
/**
 * Dienstpagina. $page (fields), $service, $crumbs
 */
$svcReviews = reviews_for_service($page['label'] ?? $service['title'], 6);

// Prijzen filteren op content_showpriceid (oude volgorde 1..8)
$allGroups = price_groups_with_items();
$ids = array_filter(array_map('trim', explode(',', (string)($page['content_showpriceid'] ?? ''))));
$groups = [];
foreach ($ids as $id) {
    $idx = (int)$id - 1;
    if (isset($allGroups[$idx])) $groups[] = $allGroups[$idx];
}

// Voor/na voorbeelden
$examples = json_decode($page['content_examples'] ?? '[]', true) ?: [];
$mediaBase = 'reinigen/' . $service['slug'];
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

                        <?php if (($page['enable_contact'] ?? '0') === '1'): ?>
                            <?php view('group_communication'); ?>
                        <?php endif; ?>

                        <?= ktext($page['content_description'] ?? '') ?>
                    </div>

                    <?php if ($examples): ?>
                        <div class="example">
                            <?php foreach ($examples as $ex): ?>
                                <?php
                                $preImg = media_path_of($ex['content_img_pre'] ?? null, $mediaBase);
                                $afterImg = media_path_of($ex['content_img_after'] ?? null, $mediaBase);
                                if ($preImg && $afterImg):
                                    view('ba_slider', ['before' => $preImg, 'after' => $afterImg,
                                        'altBefore' => $ex['content_text_pre'] ?? '', 'altAfter' => $ex['content_text_after'] ?? '']);
                                endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif (!empty($page['content_text_pre']) && $page['content_text_pre'] !== ''): ?>
                        <?php
                        $preImg = media_path_of($page['content_img_pre'] ?? null, $mediaBase);
                        $afterImg = media_path_of($page['content_img_after'] ?? null, $mediaBase);
                        if ($preImg && $afterImg):
                            view('ba_slider', ['before' => $preImg, 'after' => $afterImg,
                                'altBefore' => $page['content_text_pre'], 'altAfter' => $page['content_text_after'] ?? '']);
                        endif; ?>
                    <?php endif; ?>

                    <?php
                    // Video (bijv. matrasreiniging)
                    $videoFile = MEDIA_DIR . '/' . $mediaBase . '/' . $service['slug'] . '-video.mp4';
                    $videoThumb = MEDIA_DIR . '/' . $mediaBase . '/' . $service['slug'] . '-video.jpg';
                    ?>
                    <?php if (file_exists($videoFile)): ?>
                        <div class="cont-html"><?= ktext($page['content_video_description'] ?? '') ?></div>
                        <style>video{width:100%;height:auto;margin-top:16px;}</style>
                        <video preload="preload" controls="controls" <?php if (file_exists($videoThumb)): ?>poster="/media/<?= h($mediaBase) ?>/<?= h($service['slug']) ?>-video.jpg"<?php endif; ?>>
                            <source src="/media/<?= h($mediaBase) ?>/<?= h($service['slug']) ?>-video.mp4" type="video/mp4"/>
                        </video>
                    <?php endif; ?>

                    <div class="cont-html">
                        <?= ktext($page['content_intro_price'] ?? '') ?>
                        <?= ktext($page['content_price'] ?? '') ?>
                    </div>

                    <?php if ($groups): ?>
                        <?php view('prices_block', ['groups' => $groups]); ?>
                    <?php endif; ?>

                    <?php if ($svcReviews): ?>
                    <div class="review review--full">
                        <div class="cont-html"><h2>Dit vinden onze klanten</h2></div>
                        <?php view('reviews_block', ['reviews' => $svcReviews, 'showHeading' => false, 'amountColumn' => 2]); ?>
                    </div>
                    <?php endif; ?>

                    <?php if (($page['enable_contact'] ?? '0') === '1'): ?>
                        <?php view('group_communication'); ?>
                    <?php endif; ?>

                </div>

            </div>


            <div class="article-02__col-2">

                <div class="article-02__box">
                    <?php view('sidebar', ['showWhy' => ($page['enable_contact'] ?? '0') !== '1']); ?>
                </div>

            </div>
        </div>


        <?php view('locations_block', ['service' => $service, 'limit' => 60]); ?>

    </div>
</section>
