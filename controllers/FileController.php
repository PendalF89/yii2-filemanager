<?php

namespace pendalf89\filemanager\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use pendalf89\filemanager\models\Mediafile;
use pendalf89\filemanager\assets\FilemanagerAsset;

class FileController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (defined('YII_DEBUG') && YII_DEBUG) {
            Yii::$app->assetManager->forceCopy = true;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFilemanager()
    {
        $this->layout = '@vendor/pendalf89/yii2-filemanager/views/layouts/main';
        $model = new Mediafile();
        $dataProvider = $model->search();
        $dataProvider->pagination->defaultPageSize = 15;

        return $this->render('filemanager', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUploadmanager()
    {
        $this->layout = '@vendor/pendalf89/yii2-filemanager/views/layouts/main';
        return $this->render('uploadmanager', ['model' => new Mediafile()]);
    }

    /**
     * Provides upload file
     * @return mixed
     */
    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Mediafile();
        $routes = $this->module->routes;
        $model->saveUploadedFile($routes);
        $bundle = FilemanagerAsset::register($this->view);

        if ($model->isImage()) {
            $model->createThumbs($routes, $this->module->thumbs);
        }

        $response['files'][] = [
            'url'           => $model->url,
            'thumbnailUrl'  => $model->getDefaultThumbUrl($bundle->baseUrl),
            'name'          => $model->filename,
            'type'          => $model->type,
            'size'          => $model->file->size,
            'deleteUrl'     => Yii::$app->urlManager->createUrl(['/filemanager/file/delete', 'id' => $model->id]),
            'deleteType'    => 'POST',
        ];

        return $response;
    }

    /**
     * Delete model with files
     * @param $id
     * @return array
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $routes = $this->module->routes;

        $model = Mediafile::findOne($id);

        if ($model->isImage()) {
            $model->deleteThumbs($routes);
        }

        $model->deleteFile($routes);
        $model->delete();

        return ['success' => 'true'];
    }

    /**
     * Resize all thumbnails
     */
    public function actionResize()
    {
        $models = Mediafile::findByTypes(Mediafile::$imageFileTypes);
        $routes = $this->module->routes;

        foreach ($models as $model) {
            if ($model->isImage()) {
                $model->deleteThumbs($routes);
                $model->createThumbs($routes, $this->module->thumbs);
            }
        }

        Yii::$app->session->setFlash('successResize');
        $this->redirect(Yii::$app->urlManager->createUrl(['/filemanager/default/settings']));
    }

    /** Render model info
     * @param $id
     * @return string
     */
    public function actionInfo($id)
    {
        $model = Mediafile::findOne($id);
        return $this->renderPartial('info', ['model' => $model]);
    }
}
