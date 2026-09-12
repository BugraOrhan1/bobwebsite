<?php /** Dienstenoverzicht (/reinigen). $page, $servicesList */ ?>
<section class="article-02">
    <div class="container-fluid">

        <div class="article-02__main">
            <div class="article-02__col-1 ">
                <?php view('breadcrumb', ['crumbs' => [
                    ['title' => 'Home', 'url' => '/'],
                    ['title' => $page['title'], 'url' => '/reinigen'],
                ]]); ?>
                <div class="article-02__content">
                    <div class="cont-html">
                        <h1 class="lane__title"><?= h($page['intro_title']) ?></h1>
                        <?= ktext($page['intro_description']) ?>
                    </div>

                    <?php
                    $examples = json_decode($page['content_examples'] ?? '[]', true) ?: [];
                    ?>
                    <?php if ($examples): ?>
                    <div class="example">
                        <?php foreach ($examples as $ex): ?>
                            <div class="f-row">
                                <div class="f-col">
                                    <h2 class="example__title"><?= h($ex['content_text_pre'] ?? '') ?></h2>
                                    <?php if (!empty($ex['content_img_pre']) && file_exists(MEDIA_DIR . '/reinigen/' . $ex['content_img_pre'])): ?>
                                        <p class="example__desc"><img class="example__img" loading="lazy" alt="<?= h($ex['content_text_pre'] ?? '') ?>" src="/media/reinigen/<?= h($ex['content_img_pre']) ?>"></p>
                                    <?php endif; ?>
                                </div>
                                <div class="f-col">
                                    <h2 class="example__title"><?= h($ex['content_text_after'] ?? '') ?></h2>
                                    <?php if (!empty($ex['content_img_after']) && file_exists(MEDIA_DIR . '/reinigen/' . $ex['content_img_after'])): ?>
                                        <p class="example__desc"><img class="example__img" loading="lazy" alt="<?= h($ex['content_text_after'] ?? '') ?>" src="/media/reinigen/<?= h($ex['content_img_after']) ?>"></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="service-list">
                        <ul class="service-items">
                            <?php foreach ($servicesList as $item): ?>
                                <li class="service-item">
                                    <a class="service-item__link" title="<?= h($item['title']) ?>" href="/reinigen/<?= h($item['slug']) ?>">
                                        <h3 class="service-item__title"><?= h($item['title']) ?></h3>
                                        <div class="service-item__image">
                                            <?php if (!empty($item['icon']) && file_exists(MEDIA_DIR . '/' . $item['icon'])): ?>
                                                <?= file_get_contents(MEDIA_DIR . '/' . $item['icon']) ?>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="article-02__col-2">
                <div class="article-02__box">
                    <?php view('sidebar', ['showWhy' => true]); ?>
                </div>
            </div>
        </div>

        <?php view('locations_block', ['service' => $servicesList[0], 'limit' => 60]); ?>

    </div>
</section>
