<?php
/** Veelgestelde vragen (uit de database, bewerkbaar via /admin) */
$faqs = db()->query('SELECT * FROM faqs WHERE active = 1 ORDER BY sort ASC, id ASC')->fetchAll();
if (!$faqs) return;
?>
<section class="lane lane-faq">
    <div class="container-fluid">
        <h2 class="title" style="text-align:center">Veelgestelde vragen</h2>
        <div class="faq">
            <?php foreach ($faqs as $faq): ?>
                <details>
                    <summary><?= h($faq['question']) ?></summary>
                    <div class="faq__answer"><?= ktext($faq['answer']) ?></div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
