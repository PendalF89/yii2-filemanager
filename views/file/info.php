<?php

use pendalf89\filemanager\assets\FilemanagerAsset;
use pendalf89\filemanager\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pendalf89\filemanager\models\Mediafile */
/* @var $dataProvider yii\data\ActiveDataProvider */
$bundle = FilemanagerAsset::register($this);
?>

<?= Html::img($model->getDefaultThumbUrl($bundle)) ?>
<ul class="detail">
    <li><?= $model->filename ?></li>
</ul>
