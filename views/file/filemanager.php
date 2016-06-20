<?php

use pendalf89\filemanager\assets\FilemanagerAsset;
use pendalf89\filemanager\Module;
use pendalf89\filemanager\models\Tag;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel pendalf89\filemanager\models\MediafileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['moduleBundle'] = FilemanagerAsset::register($this);
?>

<header id="header"><span class="glyphicon glyphicon-picture"></span> <?= Module::t('main', 'File manager') ?></header>

<div id="filemanager" data-url-info="<?= Url::to(['file/info']) ?>">

    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'action' => '?',
        'method' => 'get',
    ]); ?>
        <div class="row">

            <div class="col-xs-6 col-md-4">
                <?= $form->field($model, 'tagIds')->widget(\kartik\select2\Select2::className(), [
                    'maintainOrder' => true,
                    'data' => ArrayHelper::map(Tag::find()->all(), 'id', 'name'),
                    'options' => ['multiple' => true],
                ])->label(false); ?>
            </div>

            <div class="col-xs-6 col-md-4">
                <?= Html::submitButton(Yii::t('app', 'btn_search'), ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    <?php \yii\bootstrap\ActiveForm::end(); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '<div class="items">{items}</div>{pager}',
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
                    return Html::a(
                        Html::img($model->getDefaultThumbUrl($this->params['moduleBundle']->baseUrl))
                        . '<span class="checked glyphicon glyphicon-check"></span>',
                        '#mediafile',
                        ['data-key' => $key]
                    );
            },
    ]) ?>

    <div class="dashboard">
        <p><?= Html::a('<span class="glyphicon glyphicon-upload"></span> ' . Module::t('main', 'Upload manager'),
                ['file/uploadmanager'], ['class' => 'btn btn-default']) ?></p>
        <div id="fileinfo">

        </div>
    </div>
</div>
