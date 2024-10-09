<?php
/** @var string $slot */
?>
<!doctype html>
<html lang="en">
<head>
    <title>Base layout</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative bg-gray-100 text-black dark:bg-gray-900 dark:text-white selection:bg-violet-400 dark:selection:bg-violet-800 dark:selection:text-white">
<div class="relative flex flex-col min-h-screen overflow-hidden">
    <?= $slot ?>
</div>
</body>
</html>
