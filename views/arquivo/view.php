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

$this->title = $model->filename;

$this->params['breadcrumbs'][] = ['label' => 'Arquivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    
    <div class="col-md-6">
        <?php
        
        if($model->isVideo()){
            
            echo Html::tag('video', Html::tag('source', Module::t("main", "Your browser is not suported"), 
                        ['src' => $model->url, 'type'=>$model->type]), ['controls'=>'all','width' => '100%']);
                                    
        }elseif($model->isDocument()){
            
            echo Html::tag('iframe', null,['src' => $model->url, 'width' => '100%','height' => '570px']);
            
        }else{
            
            echo $model->getThumbImage('large');
            
        }
        ?>
        <br>
        <?=Html::a('<i class="fa fa-external-link"></i> ' . Module::t('main', 'Open in new window'), $model->url, ['target'=>'blank'])?> 
    </div>
    
    <div class="col-md-6">
        <?=Html::tag('p', Html::tag('strong',$model->getAttributeLabel('description') . ': ') . $model->description);?>
        <hr>
        <?=Html::tag('p', Html::tag('strong',$model->getAttributeLabel('palavras_chaves_arquivos') . ': ') . 
                $model->getPalavrasChavesArquivos('; '));?>
        <hr>
        <?=Html::tag('p', Html::tag('strong', Module::t('main', 'Updated at') . ': ') . date('d/m/Y H:i:s',$model->getLastChanges())); ?>
        
        <?=Html::tag('p', Html::tag('strong', Module::t('main', 'Size') . ': ') . $model->getFileSize()); ?>
        
        <?php if ($model->isImage()) : ?>
            <?=Html::tag('p', Html::tag('strong', Module::t('main', 'Resolution') . ': ') . $model->getOriginalImageSize($this->context->module->routes)); ?>
        <?php endif; ?>
        <hr>
        <?=Html::tag('p', Html::tag('strong',$model->getAttributeLabel('var_referencia_id') . ': ')) .
                $model->getReferenciasArquivos();?>
    </div>
</div>
     
