<?php

namespace nullref\cms;


use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $prefix = $app->getModule('cms')->urlPrefix;
        $app->urlManager->addRules([
            $prefix.'/<route:[a-zA-Z0-9-/]+>' => '/cms/page/index'
        ]);
    }

}