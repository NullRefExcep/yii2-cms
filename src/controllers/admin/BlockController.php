<?php

namespace nullref\cms\controllers\admin;

use nullref\cms\models\Block;
use nullref\cms\models\BlockSearch;
use nullref\cms\models\PageHasBlock;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BlockController implements the CRUD actions for Block model.
 */
class BlockController extends Controller implements IAdminController
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
     * @param null $id
     * @return string|\yii\web\Response
     */
    public function actionConfig($id = null)
    {
        /** @var Block $model */
        if ($id === null) {
            $model = Yii::$app->session->get('new-block');
            if (!$model) {
                $this->redirect('create');
            }
        } else {
            $model = $this->findModel($id);
        }
        /** @var \nullref\cms\components\BlockManager $blockManager */
        $blockManager = Yii::$app->getModule('cms')->get('blockManager');

        /** @var \nullref\cms\components\Block $block */
        $block = $blockManager->getBlock($model->class_name);

        if (!$model->isNewRecord) {
            $block->setAttributes($model->getData());
        }

        if ($block->load(Yii::$app->request->post()) && ($block->validate())) {
            $model->setData($block);
            $model->save();
            TagDependency::invalidate(Yii::$app->cache, 'cms.block.' . $model->id);
            TagDependency::invalidate(Yii::$app->cache, 'cms.block.' . $model->oldAttributes['id']);
            Yii::$app->session->remove('new-block');

            /** Create relation when path page_id parameter */
            if ($pageId = Yii::$app->request->get('page_id')) {
                if ($id === null) {
                    $pageHasBlock = new PageHasBlock(['page_id' => $pageId, 'block_id' => $model->id]);
                    $pageHasBlock->save(false, ['page_id', 'block_id']);
                }
                return $this->redirect(['/cms/admin/page/update', 'id' => $pageId]);
            }

            if ($redirect = Yii::$app->request->get('redirect_to')) {
                return $this->redirect($redirect);
            }

            return $this->redirect(['view', 'id' => $model->id, 'page_id' => $pageId]);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('config', [
                'block' => $block,
            ]);
        }
        return $this->render('config', [
            'block' => $block,
        ]);
    }

    /**
     * Finds the Block model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Block the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Block::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all Block models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Block model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Block model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Yii::createObject(Block::className());

        if ($pageId = Yii::$app->request->get('page_id')) {
            $model->visibility = Block::VISIBILITY_PROTECTED;
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->set('new-block', $model);
            return $this->redirect(['config', 'page_id' => $pageId]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Block model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $pageId = Yii::$app->request->get('page_id');
            TagDependency::invalidate(Yii::$app->cache, 'cms.block.' . $model->id);
            TagDependency::invalidate(Yii::$app->cache, 'cms.block.' . $model->oldAttributes['id']);
            return $this->redirect(['config', 'id' => $model->id, 'page_id' => $pageId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Block model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        TagDependency::invalidate(Yii::$app->cache, 'cms.block.' . $id);

        return $this->redirect(['index']);
    }
}
