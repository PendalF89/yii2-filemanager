<?php

use dosamigos\fileupload\FileUploadUI;
use pendalf89\filemanager\assets\ModuleAsset;

$bundle = ModuleAsset::register($this);
?>
<div class="container-fluid">
    <?= FileUploadUI::widget([
        'model' => $model,
        'attribute' => 'file',
        'url' => ['upload'],
        'gallery' => false,
    ]) ?>
</div>



<?php


//echo \yii\helpers\Html::img($bundle->baseUrl . '/images/file.png');
//$model = \pendalf89\filemanager\models\Mediafile::findOne(22);
//$model->deleteThumbs($this->context->module->routes);

$models = \pendalf89\filemanager\models\Mediafile::findByTypes(\pendalf89\filemanager\models\Mediafile::$imageFileTypes);

foreach ($models as $model) {

    echo '<ul>';

    //$defaultImg = \yii\helpers\Html::img($model->getDefaultThumbUrl());
    //echo "<li>По-умолчанию: <br>$defaultImg</li>";
    echo $model->filename;
    foreach ($model->getThumbs() as $alias => $thumb) {
        $img = \yii\helpers\Html::img($thumb);
        echo "<li>$alias<br>$img</li>";
    }

    echo '</ul>';
}