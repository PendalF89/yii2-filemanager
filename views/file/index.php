<?php

use yii\widgets\ActiveForm;
use pendalf89\blog\models\Post;
use pendalf89\filemanager\widgets\FileInput;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $model = new Post();?>
<?php $model = Post::findOne(1);?>

<style>
    .img {
        width: 200px;
    }

    .img img {
        max-width: 100%;
    }
</style>
<div class="img"></div>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'original_thumbnail')->widget(FileInput::className(), [
        'options' => ['class' => 'form-control'],
        'thumb' => 'original',
        'imageContainer' => '.img',
        'hideInputField' => true,
        'callbackBeforeInsert' => 'function(e, data) {
            console.log( data );
        }',
    ]); ?>

    <?= $form->field($model, 'title')->widget(FileInput::className(), [
        'options' => ['class' => 'form-control'],
        'thumb' => 'large',
        'callbackBeforeInsert' => 'function(e, data) {
            console.log( data.url );
        }',
    ]); ?>

<?php ActiveForm::end(); ?>