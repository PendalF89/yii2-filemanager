<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use douglasmk\filemanager\assets\FilemanagerAsset;
use douglasmk\filemanager\Module;
use kartik\widgets\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;


use obsrepo\obsref\Obsref;

/* @var $this yii\web\View */
/* @var $model douglasmk\filemanager\models\Mediafile */
/* @var $form yii\widgets\ActiveForm */

$bundle = FilemanagerAsset::register($this);
?>

<?php $form = ActiveForm::begin([
    //'action' => ['file/update', 'id' => $model->id],
    'action' => array_merge(['file/update'], Yii::$app->request->get()),
    'options' => ['id' => 'control-form'],
]); ?>

    <div class="panel panel-warning" style="margin-bottom:0px;">
        <div class="panel-heading">
            <h4>
                <h1 class="panel-title" style="letter-spacing: 3px;"><span class="fa fa-file"></span> Editar arquivo <?= $model->filename ?></h1>
            </h4>
        </div>
        <div class="panel-body container-fluid">

            <div class="col-xs-9">

                <?php if ($message = Yii::$app->session->getFlash('mediafileUpdateResult')) : ?>
                    <div class="alert alert-success" role="alert"><?= $message ?> <button type="button" class="close" aria-label="Close" data-dismiss='alert'><span aria-hidden="true">&times;</span></button></div>
                <?php endif; ?>


                    <?php $url_palavras_chaves = Url::to(['palavras-chaves-lista']); ?>

                    <?= $form->field($model, 'palavras_chaves_arquivos')->widget( Select2::classname(), [
                        'data'=>$palavrasChavesData,
                        'options' => ['placeholder' => 'selecione ›'],
                        'pluginOptions' => [
                            'allowClear' => false,
                            #'id' => new JsExpression(" function(params){ return params.id; } "),
                            'maximumInputLength' => 15,
                            'minimumInputLength' => 2,
                            'multiple'=>true,
                            'tags'=>true,
                            'tokenSeparators'=>[','],
                            'createTag'=> new JsExpression( "function (term, data) {
                                    if ($(data).filter(function() {
                                        return this.text.localeCompare(term)===0;
                                    }).length===0) {
                                        return { id: $.trim(term.term) + ' (nova tag)', text: $.trim(term.term) + ' (nova tag)' };
                                    }
                                }"),
                            'ajax' => [
                                'url' => $url_palavras_chaves,
                                'delay' => 500,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return { search: params.term }; }'),
                                'processResults' => new JsExpression('function(data,page) { return { results: data.items }; }'),
                            ],
                        ],
                    ]); ?>

                    <?php if ($model->isImage()) : ?>
                        <?= $form->field($model, 'alt')->textInput(['class' => 'form-control input-sm']); ?>
                    <?php endif; ?>

                    <?= $form->field($model, 'description')->textarea(['class' => 'form-control input-sm']); ?>

                    <?php if ($model->isImage()) : ?>
                        <div class="form-group<?= $strictThumb ? ' hidden' : '' ?>">
                            <?= Html::label(Module::t('main', 'Select image size'), 'image', ['class' => 'control-label']) ?>

                            <?= Html::dropDownList('url', $model->getThumbUrl($strictThumb), $model->getImagesList($this->context->module), [
                                'class' => 'form-control input-sm'
                            ]) ?>
                            <div class="help-block"></div>
                        </div>
                    <?php else : ?>
                        <?= Html::hiddenInput('url', $model->url) ?>
                    <?php endif; ?>

                    <?= Html::hiddenInput('id', $model->id) ?>

                    <?php #Html::button(Module::t('main', 'Insert'), ['id' => 'insert-btn', 'class' => 'btn btn-primary btn-sm']) ?>


                        
                        
                        
                    <?php 
                        $ref = new Obsref();
                        echo $ref->campoReferencia($form,$model->vinculosArquivosReferencias,'var_referencia_id',$this);
                     ?>










            </div>

            <div class="col-xs-3">
                <div class="thumbnail">
                    <?php
                    if($model->isImage()){
                        echo Html::img(Yii::getAlias('@web').$model->getDefaultThumbUrl($bundle->baseUrl), ['class'=> 'img-rounded']);
                    }
                    ?>
                    <div class="caption">
                        <dl>
                            <dt><?= Module::t('main', 'Type');?></dt>
                            <dd><?= $model->type ?></dd>
                            <dt><?= Module::t('main', 'Updated at');?></dt>
                            <dd><?=date('d/m/Y H:i:s',$model->getLastChanges()); ?></dd>
                            <?php if ($model->isImage()) : ?>
                                <dt><?= Module::t('main', 'Resolution');?></dt>
                                <dd><?= $model->getOriginalImageSize($this->context->module->routes) ?></dd>
                            <?php endif; ?>
                            <dt><?= Module::t('main', 'Size');?></dt>
                            <dd><?= $model->getFileSize() ?></dd>
                        </dl>
                    </div>
                </div>
            </div>

        </div>

        <div class="panel-footer">
            <?= Html::submitButton(Module::t('main', 'Save'), ['class' => 'btn btn-success']) ?>

            <?= Html::a(Module::t('main', 'Cancel'), ['file/filemanager'],['class'=>'btn btn-warning']) ?>

            <?= Html::a(Module::t('main', 'Delete'), ['file/delete/', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-id' => $model->id,
                    'role' => 'delete',
                ]
            ) ?>

            <?= Html::a(Module::t('main', 'Back to file manager'), ['file/filemanager'],['class'=>'pull-right btn btn-primary']) ?>
        </div>

    </div>

<?php 
ActiveForm::end(); 
echo $ref->modalReferencia();
?>
