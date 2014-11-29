<?php

namespace pendalf89\filemanager\assets;

use yii\web\AssetBundle;

class ModuleAsset extends AssetBundle
{
    public $sourcePath = '@vendor/pendalf89/yii2-filemanager/assets/source';
    public $depends = ['yii\bootstrap\BootstrapAsset'];
}
