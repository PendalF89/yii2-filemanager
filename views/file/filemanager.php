<?php

use pendalf89\filemanager\assets\FilemanagerAsset;
use pendalf89\filemanager\Module;
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel pendalf89\filemanager\models\Mediafile */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['moduleBundle'] = FilemanagerAsset::register($this);
?>

<header id="header"><span class="glyphicon glyphicon-picture"></span> <?= Module::t('main', 'File manager') ?></header>

<div id="filemanager" data-url-info="<?= Url::to(['file/info']) ?>">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '<div class="items">{items}</div>{pager}',
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
               if(file_exists(substr($model->getDefaultThumbUrl($this->params['moduleBundle']->baseUrl), 1))){
                    return Html::a(
                        Html::img(Yii::getAlias('@web').$model->getDefaultThumbUrl($this->params['moduleBundle']->baseUrl))
                        . '<span class="checked glyphicon glyphicon-check"></span>',
                        '#mediafile',
                        ['data-key' => $key]
                    );
                }
                else{
                    return null;
                }
            },
    ]) ?>

    <div class="dashboard">
        <p><?= Html::a('<span class="glyphicon glyphicon-upload"></span> ' . Module::t('main', 'Upload manager'),
                ['file/uploadmanager'], ['class' => 'btn btn-default']) ?></p>
        <div id="fileinfo">

        </div>
    </div>
</div>