<?php

namespace nullref\cms\controllers\admin;

use nullref\cms\models\Page;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller implements IAdminController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Page::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($continue_edit = false)
    {
        /** @var Page $model */
        $model = Yii::createObject(Page::className());

        if ($model->loadWithRelations(Yii::$app->request->post()) && $model->save()) {
            if (!$continue_edit) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', Yii::t('cms', 'Page was created'));
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $continue_edit = false)
    {
        $model = $this->findModel($id);

        $default = Yii::$app->request->isPost ? ['PageHasBlock' => []] : [];
        if ($model->loadWithRelations(array_merge($default, Yii::$app->request->post())) && $model->save()) {
            TagDependency::invalidate(Yii::$app->cache, 'cms.page.' . $model->route);
            TagDependency::invalidate(Yii::$app->cache, 'cms.page.' . $model->oldAttributes['route']);
            if (!$continue_edit) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', Yii::t('cms', 'Page was updated'));
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        TagDependency::invalidate(Yii::$app->cache, 'cms.page.' . $model->route);

        return $this->redirect(['index']);
    }

    /**
     * //very WIP
     *
     * @param $id
     * @return string
     */
    public function actionWysiwyg($id)
    {
        $model = $this->findModel($id);
        if ($model->layout) {
            $this->layout = $model->layout;
        }
        return $this->render('wysiwyg', [
            'model' => $model,
        ]);
    }
}
