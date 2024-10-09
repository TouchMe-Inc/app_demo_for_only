<?php
/** @var string $customString */

use App\Views\View;

?>
<?= View::component("Header") ?>
<?= View::component("TopGradient") ?>
    <main class="flex-grow my-6">
        <section>
            <div class="px-6 max-w-6xl mx-auto">
                <?= "Page: home. Custom data: {$customString}" ?>
            </div>
        </section>
    </main>
<?= View::component("Footer") ?>
