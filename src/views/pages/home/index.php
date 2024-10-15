<?php

use App\Views\View;

?>
<?= View::component("Header") ?>
<?= View::component("TopGradient") ?>
<main class="flex-grow my-6">
    <section>
        <div class="px-6 max-w-6xl mx-auto">
            <div class="pt-20 pb-16">
                <div class="text-center">
                    <h1 class="text-5xl font-bold tracking-tight pb-4 text-white/90">Demo project</h1>
                    <p class="text-xl text-gray-300/90">A small project that is implemented using native PHP routing and
                        containerization</p>
                </div>
            </div>
        </div>
    </section>
</main>
<?= View::component("Footer") ?>
