<?php

namespace App\Bootstrap;

use App\Security\YandexSmartCaptcha;
use Core\Application;
use Core\Bootstrap\Interface\Bootstrapper;

class BindYandexSmartCaptcha implements Bootstrapper
{

    public function bootstrap(Application $app): void
    {
        $configuration = $app->configuration()->get("yandex_smart_captcha");
        $yandexSmartCaptcha = new YandexSmartCaptcha($configuration['url'], $configuration['client_key'], $configuration['server_key']);

        $app->container()->addInstance(YandexSmartCaptcha::class, $yandexSmartCaptcha);
    }
}