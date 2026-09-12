<?php
/**
 * EENMALIGE opruim-script voor de live hosting.
 * 1x aanroepen via https://test.reinigingsdokter.nl/eenmalig-opruimen.php
 * Verwijdert daarna zichzelf.
 */
require __DIR__ . '/app/config.php';
require __DIR__ . '/app/helpers.php';
require __DIR__ . '/app/db.php';

$p = db();
$voor = (int)$p->query('SELECT COUNT(*) FROM cities')->fetchColumn();
$p->exec("DELETE FROM cities WHERE slug = 's' OR name = '%s'");
$na = (int)$p->query('SELECT COUNT(*) FROM cities')->fetchColumn();

header('Content-Type: text/plain; charset=utf-8');
echo "Klaar. Steden voor: $voor, na: $na.\n";
echo "Spookstad verwijderd uit de sitemap.\n";

@unlink(__FILE__);
echo "Script heeft zichzelf verwijderd.\n";
