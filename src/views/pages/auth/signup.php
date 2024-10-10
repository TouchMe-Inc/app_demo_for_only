<?php

use App\Views\View;

?>
<main class="flex-grow my-6">
    <section>
        <div class="px-6 max-w-6xl mx-auto">
            <div class="text-center">
                <h1 class="text-3xl">Create your account</h1>
            </div>
            <div class="mx-auto max-w-xs">
                <form method="post">
                    <div class="mb-4">
                        <label for="name" class="block mb-1 text-sm ">Name <span class="text-red-500">*</span></label>
                        <input id="name" type="text" required
                               class="w-full text-sm px-3 py-2 bg-gray-800 rounded-lg border border-transparent focus:border-purple-600 focus:outline-none"/>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block mb-1 text-sm">Email <span class="text-red-500">*</span></label>
                        <input id="email" type="email" required
                               class="w-full text-sm px-3 py-2 bg-gray-800 rounded-lg border border-transparent focus:border-purple-600 focus:outline-none"/>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block mb-1 text-sm">Phone <span class="text-red-500">*</span></label>
                        <input id="phone" type="tel" required
                               class="w-full text-sm px-3 py-2 bg-gray-800 rounded-lg border border-transparent focus:border-purple-600 focus:outline-none"/>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block mb-1 text-sm">Password <span
                                    class="text-red-500">*</span></label>
                        <input id="password" type="password" required
                               class="w-full text-sm px-3 py-2 bg-gray-800 rounded-lg border border-transparent focus:border-purple-600 focus:outline-none"/>
                    </div>
                    <div class="mb-8">
                        <label for="repassword" class="block mb-1 text-sm">Re-password <span
                                    class="text-red-500">*</span></label>
                        <input id="repassword" type="password" required
                               class="w-full text-sm px-3 py-2 bg-gray-800 rounded-lg border border-transparent focus:border-purple-600 focus:outline-none"/>
                    </div>
                    <div>
                        <button class="w-full px-3 py-2 rounded-lg bg-purple-600" type="submit">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<?= View::component("Footer") ?>
