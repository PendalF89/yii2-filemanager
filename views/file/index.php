<?php

use pendalf89\filemanager\Module;
use pendalf89\filemanager\assets\ModalAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Module::t('main', 'Files');
$this->params['breadcrumbs'][] = ['label' => Module::t('main', 'File manager'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

ModalAsset::register($this);
?>

<iframe src="<?= Url::to(['file/filemanager']) ?>" id="post-original_thumbnail-frame" frameborder="0" role="filemanager-frame"></iframe>