<?php

namespace pendalf89\filemanager\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSettings()
    {
        return $this->render('settings');
    }

    /**
     * Thumbnails resize
     */
    public function actionResize()
    {
//        $models = Post::find()->onCondition(['!=', 'thumbnails', ''])->all();
//        $presets = $this->module->thumbnails;
//        $thumbnailsBasePath  = $this->module->thumbnailsBasePath;
//
//        foreach ($models as $model) {
//            $model->deleteThumbnails($thumbnailsBasePath);
//            $model->createThumbnails($presets, $thumbnailsBasePath);
//            $model->save();
//        }
//
//        Yii::$app->session->setFlash('successResize');
//        $this->redirect('settings');
    }
}
