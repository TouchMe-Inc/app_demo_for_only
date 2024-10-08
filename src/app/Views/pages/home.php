<?php
/** @var string $customString */
?>
<?php require __DIR__ . '/../components/header.php' ?>
<main class="flex-grow my-6">
    <section>
        <div class="px-6 max-w-6xl mx-auto">
            <?= "Page: home. Custom data: {$customString}" ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/../components/footer.php' ?>