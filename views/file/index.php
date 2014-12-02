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

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'original_thumbnail')->widget(FileInput::className(), [
        'options' => ['class' => 'form-control'],
        'thumb' => 'original',
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