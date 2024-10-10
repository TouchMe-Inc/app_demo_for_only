<?php
/** @var User[] $users */

use App\Models\User;
use App\Views\View;

?>
<?= View::component("Header") ?>
<main class="flex-grow my-6">
    <section>
        <div class="px-6 max-w-6xl mx-auto">
            <div class="grid md:grid-cols-12 gap-6">
                <div class="md:col-span-3"></div>
                <div class="md:col-span-9 lg:col-span-6">
                    <div class="flex flex-wrap gap-6">
                        <?php foreach ($users as $user): ?>
                            <div
                                    class="z-20 relative overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 w-full">
                                <?= View::component("RadianGradient") ?>
                                <div class="p-6">
                                    <div class="flex items-center space-x-2">
                                        <img class="rounded-full w-6 h-6"
                                             src="/img/unnamed.jpg"
                                             alt="Jese Leos avatar"/>
                                        <div class="flex-grow">
                                            <div class="text-sm space-x-2">
                                                <span class="font-bold"><?= $user->getName() ?></span>
                                                <span>·</span>
                                                <time class="font-normal dark:text-slate-400">
                                                    <?= $user->getEmail() ?>
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
    </section>
</main>
<?= View::component("Footer") ?>
