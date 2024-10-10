<?php

use App\Views\View;

?>
<main class="flex-grow my-6">
    <section>
        <div class="px-6 max-w-6xl mx-auto">
            <div class="text-center pb-8">
                <h1 class="text-4xl">Sign in your account</h1>
            </div>
            <div class="mx-auto max-w-xs">
                <form method="post">
                    <div class="mb-4">
                        <label for="name_or_email" class="block mb-1 text-sm ">Name or Email <span class="text-red-500">*</span></label>
                        <input id="name_or_email" type="text" required autofocus
                               class="w-full text-sm px-3 py-2 bg-gray-800 rounded-lg border border-transparent focus:border-purple-600 focus:outline-none"/>
                    </div>
                    <div class="mb-8">
                        <label for="password" class="block mb-1 text-sm">Password <span
                                    class="text-red-500">*</span></label>
                        <input id="password" type="password" required
                               class="w-full text-sm px-3 py-2 bg-gray-800 rounded-lg border border-transparent focus:border-purple-600 focus:outline-none"/>
                    </div>
                    <div>
                        <button class="w-full px-3 py-2 rounded-lg bg-purple-600" type="submit">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<?= View::component("Footer") ?>
