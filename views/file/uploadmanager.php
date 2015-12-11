<?php
use dosamigos\fileupload\FileUploadUI;
//use dosamigos\fileupload\FileUpload;
use douglasmk\filemanager\Module;
use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel douglasmk\filemanager\models\Mediafile */

?>

<div class="panel panel-warning" style="margin-bottom:0px;">
    <div class="panel-heading">
        <h4>
            <h1 class="panel-title" style="letter-spacing: 3px;"><span class="glyphicon glyphicon-upload"></span> <?= Module::t('main', 'Upload manager') ?></h1>
        </h4>
    </div>
    <div class="panel-body container-fluid">

        <div id="uploadmanager">

            <?= FileUploadUI::widget([
                'model' => $model,
                'attribute' => 'file',
                'formView' => 'form',
                'fieldOptions' => [
                        //'accept' => ['image/*', 'video/webm', 'video/mp4', 'image/ogg', 'application/pdf']
                ],
                'clientOptions' => [
                    'maxNumberOfFiles'=> 1,
                    'autoUpload'=> Yii::$app->getModule('filemanager')->autoUpload,
                    'maxFileSize' => 96000000
                ],

                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {
                        window.location.href = data.result.files[0].updateUrl;
                    }',
                ],
                'url' => ['upload'],
                'gallery' => false,
            ]) ?>

        </div>
    </div>
    <div class="panel-footer">
        <?= Html::a('<i class="fa fa-arrow-left"></i> ' . Module::t('main', 'Back to file manager'), ['file/filemanager'],['class'=>'btn btn-primary']); ?>
    </div>
</div>
