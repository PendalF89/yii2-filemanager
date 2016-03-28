<?php
use dosamigos\fileupload\FileUploadUI;
//use dosamigos\fileupload\FileUpload;
use douglasmk\filemanager\Module;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\Alert;

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

            <?= Alert::widget([
                'options'   => ['class' => 'alert-danger text-center hide fade in dimiss'],
                'body'      => Yii::$app->session->getFlash('error')
            ]);
            ?>


            <?= FileUploadUI::widget([
                'model' => $model,
                'attribute' => 'file',
                'formView' => 'form',
                'fieldOptions' => [
                        //'accept' => ['image/*', 'video/webm', 'video/mp4', 'image/ogg', 'application/pdf']
                ],
                'clientOptions' => [
                    'maxNumberOfFiles'=> 1,
                    'autoUpload'=> Yii::$app->getModule('arquivos')->autoUpload,
                    'maxFileSize' => 96000000
                ],

                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {
                        $(".alert-danger").html("").addClass("hide");
                        console.log(data.result);
                        if(!!data.result.error){
                            $(".alert-danger").html(data.result.error).removeClass("hide");
                        }else{
                            $("#loading").show();
                            window.location.href = data.result.files[0].updateUrl;
                        }
                    }',
                ],
                'url' => ['upload','modal' => Yii::$app->request->get('modal')],
                'gallery' => false,
            ]) ?>

        </div>
    </div>
    <div class="panel-footer">
        <?= Html::a('<i class="fa fa-arrow-left"></i> ' . Module::t('main', 'Back to file manager'), ['/arquivos/arquivo/gerenciar'],['class'=>'btn btn-primary']); ?>
    </div>
</div>
