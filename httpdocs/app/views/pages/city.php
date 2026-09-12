<?php
/**
 * Stadspagina: /reinigen/{dienst}/{stad}
 * $page (fields van de dienst), $service, $city, $crumbs, $introHtml, $nearby
 */
$mediaBase = 'reinigen/' . $service['slug'];

// Prijzen (zelfde selectie als de dienstpagina)
$allGroups = price_groups_with_items();
$ids = array_filter(array_map('trim', explode(',', (string)($page['content_showpriceid'] ?? ''))));
$groups = [];
foreach ($ids as $id) {
    $idx = (int)$id - 1;
    if (isset($allGroups[$idx])) $groups[] = $allGroups[$idx];
}
?>
<section class="article-02">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php view('breadcrumb', ['crumbs' => $crumbs]); ?>
                <div class="article-02__content">
                    <div class="cont-html">

                        <h1 class="lane__title">
                            <?= h($service['title']) ?> in <?= h($city['name']) ?> en omgeving
                        </h1>

                        <?php if (!empty($city['intro'])): ?>
                            <?= clean_html($city['intro']) ?>
                        <?php else: ?>
                            <?= $introHtml ?>
                        <?php endif; ?>

                        <?= ktext($page['intro_description']) ?>

                        <?php if (($page['enable_contact'] ?? '0') === '1'): ?>
                            <?php view('group_communication'); ?>
                        <?php endif; ?>

                        <?= ktext($page['content_description'] ?? '') ?>
                    </div>

                    <?php if (!empty($page['content_text_pre']) && $page['content_text_pre'] !== ''): ?>
                        <div class="example">
                            <div class="f-row">
                                <div class="f-col">
                                    <h2 class="example__title"><?= h($page['content_text_pre']) ?></h2>
                                    <?php if (!empty($page['content_img_pre']) && file_exists(MEDIA_DIR . '/' . $mediaBase . '/' . $page['content_img_pre'])): ?>
                                        <p class="example__desc"><img class="example__img" loading="lazy" alt="<?= h($page['content_text_pre']) ?>" src="/media/<?= h($mediaBase) ?>/<?= h($page['content_img_pre']) ?>"></p>
                                    <?php endif; ?>
                                </div>
                                <div class="f-col">
                                    <h2 class="example__title"><?= h($page['content_text_after'] ?? '') ?></h2>
                                    <?php if (!empty($page['content_img_after']) && file_exists(MEDIA_DIR . '/' . $mediaBase . '/' . $page['content_img_after'])): ?>
                                        <p class="example__desc"><img class="example__img" loading="lazy" alt="<?= h($page['content_text_after'] ?? '') ?>" src="/media/<?= h($mediaBase) ?>/<?= h($page['content_img_after']) ?>"></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="cont-html">
                        <?= ktext($page['content_intro_price'] ?? '') ?>
                        <?= ktext($page['content_price'] ?? '') ?>
                    </div>

                    <?php if ($groups): ?>
                        <?php view('prices_block', ['groups' => $groups]); ?>
                    <?php endif; ?>

                    <?php if ($nearby): ?>
                    <div class="cont-html">
                        <h2><?= h($service['title']) ?> in de buurt van <?= h($city['name']) ?></h2>
                        <p>Ook in deze plaatsen in de buurt van <?= h($city['name']) ?> komen wij graag langs:</p>
                        <ul class="locations__items locations__items--inline">
                            <?php foreach ($nearby as $n): ?>
                                <li class="locations__item">
                                    <a class="locations__href" href="/reinigen/<?= h($service['slug']) ?>/<?= h($n['slug']) ?>"><?= h($n['name']) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
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
