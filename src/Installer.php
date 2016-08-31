<?php
/**
 *
 */

namespace nullref\cms;

use nullref\core\components\ModuleInstaller;
use Yii;
use yii\helpers\Console;

class Installer extends ModuleInstaller
{
    public function getModuleId()
    {
        return 'cms';
    }

    public function install()
    {
        parent::install();
        if (Console::confirm('Create upload folder?')) {
            try {
                $this->createFolder('@webroot/uploads');
                Console::output('Folder @webroot/uploads was created');
            } catch (\Exception $e) {
                Console::output($e->getMessage());
            }
        }
    }
} 