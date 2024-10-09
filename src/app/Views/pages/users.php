<?php
/** @var string $customString */

use App\Views\View;

?>
<?= View::render("components/Header") ?>
    <main class="flex-grow my-6">
        <section>
            <div class="px-6 max-w-6xl mx-auto">
                <?= "Page: users" ?>
            </div>
        </section>
    </main>
<?= View::render("components/Footer") ?>
