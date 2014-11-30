<?php

use yii\helpers\Html;
use pendalf89\filemanager\Module;
use pendalf89\filemanager\assets\FilemanagerAsset;

/* @var $this yii\web\View */

$this->title = Module::t('main', 'File manager');
$this->params['breadcrumbs'][] = $this->title;

$assetPath = FilemanagerAsset::register($this)->baseUrl;
?>

<div class="filemanager-default-index">
    <h1><?= Module::t('main', 'File manager module'); ?></h1>

    <div class="row">
        <div class="col-md-6">

            <div class="text-center">
                <h2>
                    <?= Html::a(Module::t('main', 'Files'), ['/filemanager/file/index']) ?>
                </h2>
                <?= Html::a(
                    Html::img($assetPath . '/images/files.png', ['alt' => 'Files'])
                    , ['/filemanager/file/index']
                ) ?>
            </div>
        </div>

        <div class="col-md-6">

            <div class="text-center">
                <h2>
                    <?= Html::a(Module::t('main', 'Settings'), ['/filemanager/default/settings']) ?>
                </h2>
                <?= Html::a(
                    Html::img($assetPath . '/images/settings.png', ['alt' => 'Tools'])
                    , ['/filemanager/default/settings']
                ) ?>
            </div>
        </div>
    </div>
</div>