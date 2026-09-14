<?php

class DashboardController extends Kirby\Panel\Controllers\Base {

  public function index() {
      $adminUser      = panel()->user();
      return $this->screen('dashboard/index', panel()->site(), array(
      'adminUser' => $adminUser,
      'widgets' => new Kirby\Panel\Widgets()
    ));

  }

}