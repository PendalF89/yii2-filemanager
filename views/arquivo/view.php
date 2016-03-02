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
        if($model->isVideo())
        {
            echo Html::tag('video', Html::tag('source', Module::t("main", "Your browser is not suported"), [
                        'src'       => $model->url,
                        'type'      => $model->type]), [
                        'controls'  => 'all',
                        'width'     => '100%']);

        }elseif($model->isDocument()){

            echo Html::tag('iframe', null, ['src' => $model->url, 'width' => '100%','height' => '570px']);

        }else{

            echo $model->getThumbImage('large');

        }

        echo Html::tag('br');

        $newWindowLinklabel = '<i class="fa fa-external-link"></i> ' . Module::t('main', 'Open in new window');
        echo Html::a($newWindowLinklabel, $model->url, [ 'target' => 'blank', 'class' => 'btn btn-link']);

        ?>

    </div>

    <div class="col-md-6">
        <?php

        $descriptionlabel = Html::tag('strong', $model->getAttributeLabel('description') . ': ');
        echo Html::tag('p', $descriptionlabel . $model->description);

        echo Html::tag('hr');

        $palavrasChavesLabel = Html::tag('strong',$model->getAttributeLabel('palavras_chaves_arquivos') . ': ');
        echo Html::tag('p',  $palavrasChavesLabel . $model->getPalavrasChavesArquivos('; '));

        echo Html::tag('hr');

        $updatedAtLabel = Html::tag('strong', Module::t('main', 'Updated at') . ': ');
        echo Html::tag('p', $updatedAtLabel . date('d/m/Y H:i:s', $model->getLastChanges()));

        $sizeLabel = Html::tag('strong', Module::t('main', 'Size') . ': ');
        echo Html::tag('p', $sizeLabel . $model->getFileSize());

        if ($model->isImage())
        {
            $resolutionLabel = Html::tag('strong', Module::t('main', 'Resolution') . ': ');
            echo Html::tag('p', $resolutionLabel . $model->getOriginalImageSize($this->context->module->routes));
        }

        echo Html::tag('hr');

        $referenciaLabel = Html::tag('strong',$model->getAttributeLabel('var_referencia_id') . ': ');
        echo Html::tag('p', $referenciaLabel . $model->getReferenciasArquivos());

        ?>
    </div>
</div>
