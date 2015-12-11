<?php

namespace douglasmk\filemanager\assets;

use yii\web\AssetBundle;

class FileInputAsset extends AssetBundle
{
    public $sourcePath = '@vendor/douglasmk/yii2-filemanager/assets/source';

    public $js = [
        'js/fileinput.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
        'douglasmk\filemanager\assets\ModalAsset',
    ];
}
