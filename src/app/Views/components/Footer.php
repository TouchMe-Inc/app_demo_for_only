<?php

if (2024 > $year = date('Y')) {
    $year = "2024-{$year}";
};

?>

<footer class="w-full relative">
    <div class="px-6 max-w-6xl mx-auto">
        <div class="flex flex-col items-center justify-between py-8 mx-auto lg:flex-row">
            <p class="text-sm text-gray-600 dark:text-gray-400 lg:order-1 order-2 mt-6 lg:mt-0">
                © Copyright <?= $year ?> Demo.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-6 text-sm font-semibold lg:order-2 order-1">
                <a href="/"
                   class="hover:text-black text-gray-700 transition-colors duration-300 dark:text-gray-300 dark:hover:text-white"
                >
                    Home
                </a>
                <a href="/users"
                   class="hover:text-black text-gray-700 transition-colors duration-300 dark:text-gray-300 dark:hover:text-white"
                >
                    Users
                </a>
            </div>
        </div>
    </div>
</footer>
