<?php

use douglasmk\filemanager\Module;
use douglasmk\filemanager\assets\ModalAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Module::t('main', 'Files');
$this->params['breadcrumbs'][] = ['label' => Module::t('main', 'File manager'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

ModalAsset::register($this);
?>

<iframe src="<?= Url::to(['arquivo/gerenciar']) ?>" id="post-original_thumbnail-frame" frameborder="0" role="filemanager-frame"></iframe>