<?php

use App\Security\YandexSmartCaptcha;

/** @var YandexSmartCaptcha $yandexSmartCaptcha */
$yandexSmartCaptcha = app()->container()->make(YandexSmartCaptcha::class);
?>
<script src="<?= $yandexSmartCaptcha->getUrl() ?>/captcha.js" defer></script>
<div
        id="captcha-container"
        class="smart-captcha"
        data-sitekey="<?= $yandexSmartCaptcha->getClientKey() ?>"
></div>