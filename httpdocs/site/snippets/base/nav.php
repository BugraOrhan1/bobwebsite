<nav class="mobile-nav" role="navigation">
  <ul class="header__nav-items">
    <?php $activeMenuPages = $pages->visible()->filterBy('title_in_menu', '>', 0); ?>
    <?php foreach($activeMenuPages as $item): ?>
      <li class="header__nav-item <?= r($item->isOpen(), 'is-active') ?>">
        <a href="<?= $item->url() ?>"><?= $item->title()->text() ?></a>
      </li>
    <?php endforeach ?>
  </ul>

    <h3 class="mobile-nav__heading"><strong>De Reinigingsdokter</strong></h3>
    <?php snippet('shared/group-communication') ?>
</nav>

