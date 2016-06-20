<?php

use pendalf89\filemanager\Module;
use pendalf89\filemanager\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
?>
<?php $form = ActiveForm::begin(['action' => '?', 'method' => 'get']) ?>
	<?= $form->field($model, 'tagIds')->widget(\kartik\select2\Select2::className(), [
		'maintainOrder' => true,
		'data' => ArrayHelper::map(Tag::find()->all(), 'id', 'name'),
		'options' => ['multiple' => true],
		'addon' => [
			'append' => [
				'content' => Html::submitButton(Module::t('main', 'Search'), ['class' => 'btn btn-primary']),
				'asButton' => true
			]
		]
	])->label(false) ?>
<?php ActiveForm::end() ?>
