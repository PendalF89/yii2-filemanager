<?php

use pendalf89\filemanager\assets\FilemanagerAsset;
use pendalf89\filemanager\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pendalf89\filemanager\models\Mediafile */
/* @var $dataProvider yii\data\ActiveDataProvider */
$bundle = FilemanagerAsset::register($this);
?>
<?= Html::img($model->getDefaultThumbUrl($bundle->baseUrl)) ?>
<ul class="detail">
    <li><?= $model->type ?></li>
    <li><?= Yii::$app->formatter->asDatetime($model->getLastChanges()) ?></li>
    <li><?= Yii::$app->formatter->asShortSize($model->size, 0) ?></li>
    <li><?= Html::a(Module::t('main', 'Delete'), ['/filemanager/file/delete/', 'id' => $model->id],
            [
                'class' => 'text-danger',
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-id' => $model->id,
                'role' => 'delete',
            ]
        ) ?></li>
</ul>
<div class="filename">
    <?= $model->filename ?>
</div>