<?php

namespace pendalf89\filemanager\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use pendalf89\filemanager\models\Mediafile;
use pendalf89\filemanager\assets\ModuleAsset;

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

    public function actionIndex()
    {
        $this->layout = '@vendor/pendalf89/yii2-filemanager/views/layouts/main';
        return $this->render('index', ['model' => new Mediafile()]);
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

        if ($model->isImage()) {
            $model->createThumbs($routes, $this->module->thumbs);
            $thumbnailUrl = $model->getDefaultThumbUrl();
        } else {
            $bundle = ModuleAsset::register($this->view);
            $thumbnailUrl = $model->getFileThumbUrl($bundle->baseUrl);
        }

        $response['files'][] = [
            'url'           => $model->url,
            'thumbnailUrl'  => $thumbnailUrl,
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
}
