<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\cms\controllers\admin;

use nullref\core\interfaces\IAdminController;
use yii\web\Controller;


class FilesController extends Controller implements IAdminController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}