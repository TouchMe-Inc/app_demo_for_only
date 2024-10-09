<?php
/** @var string $customString */

use App\Views\View;

?>
<?= View::component("Header") ?>
    <main class="flex-grow my-6">
        <section>
            <div class="px-6 max-w-6xl mx-auto">
                <?= "Page: users" ?>
            </div>
        </section>
    </main>
<?= View::component("Footer") ?>
