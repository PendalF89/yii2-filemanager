<?php

use douglasmk\filemanager\assets\FilemanagerAsset;
use douglasmk\filemanager\Module;
use yii\widgets\ListView;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel douglasmk\filemanager\models\Mediafile */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['moduleBundle'] = FilemanagerAsset::register($this);


$this->title = Module::t('main', 'Files');
$this->params['breadcrumbs'][] = ['label' => Module::t('main', 'File manager'), 'url' => ['/arquivos\/']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="dashboard">
    <div id="filemanager" data-url-info="<?= Url::to(['arquivo/info']) ?>">
        <input type="hidden" id="arquivosSelecionados">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'id' => 'filemanagerGrid',
            'filterModel' => $modelSearch,
            'responsive'=>true,
            'panel' => [
                'heading' => '<h3 class="panel-title">'. Module::t('main', 'File manager'). '</h3>',
                'type' => GridView::TYPE_DEFAULT,
                'before' => Html::a('<i class="glyphicon glyphicon-upload"></i> ' .  Module::t('main', 'Upload manager'), ['arquivo/uploadmanager'], [
                           'type' => 'button',
                           'title' => Module::t('main', 'Upload manager'),
                           'class' => 'btn btn-success'
                       ]),
            ],
            'export' => [
                'fontAwesome' => true
            ],
            'toolbar' => [
                [
                   'content'=>
                       Html::a('<i class="glyphicon glyphicon-check"></i> ' . Module::t('main', 'Use selected'), [''], [
                           'type' => 'button',
                           'title' => Module::t('main', 'Use selected'),
                           'class' => 'btn btn-primary ' . (Yii::$app->request->get('modal')=='true' ? '' : 'hide'),
                           'id' => 'insert-btn',
                       ])
                ],
                [
                   'content'=>
                       Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['gerenciador'], [
                           'class' => 'btn btn-default',
                           'title' => Module::t('main', 'Reset Grid')
                       ]),
                ],
               '{toggleData}',
               '{export}',
            ],
            'columns' => [
                [
                    'class' => 'kartik\grid\CheckboxColumn',
                    'visible' => Yii::$app->request->get('modal')=='true',
                ],
                [
                    'attribute' => 'id',
                    'options' => ['width' => '7%'],
                ],
                [
                    'attribute' => 'filename',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'style' => 'font-size: 11px'],
                    'value' => function ($data) {

                        if($data->isVideo()){
                            return("<video height='150' controls>
                                    <source src='".$data->url."' type='".$data->type."'>
                                    " . Module::t("main", "Your browser is not suported") . "
                                </video><br>" . $data->filename);
                        }else{
                            return $data->getThumbImage('small',['style' => 'font-size: 40px']) . '<br>' . $data->filename;
                        }
                    }
                ],
                [
                    'attribute' => 'alt',
                    'options' => ['width' => '20%'],
                ],
                [
                    'attribute' => 'palavras_chaves_arquivos',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $palavrasChave = '';
                        foreach ($data->vinculosArquivosPalavrasChaves as $palavraChave) {
                            $palavrasChave .= $palavraChave['palavraChave']['pch_palavra_chave'] . '; ';
                        }
                        return ($palavrasChave);
                    }
                ],
                [
                    'header' => Module::t('main', 'Actions'),
                    'class' => 'kartik\grid\ActionColumn',
                    'options'=> ['width'=>'7%'],
                    'template' =>  Yii::$app->user->can('btt_admin') ? '{view} {update} {delete}' : '{view} {update}',
                ],
            ]
        ]); ?>
    </div>
</div>
