<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use pendalf89\filemanager\assets\FilemanagerAsset;
use pendalf89\filemanager\Module;
use pendalf89\filemanager\models\Tag;

/* @var $this yii\web\View */
/* @var $model pendalf89\filemanager\models\Mediafile */
/* @var $form yii\widgets\ActiveForm */

$bundle = FilemanagerAsset::register($this);
?>

<?= Html::img($model->getDefaultThumbUrl($bundle->baseUrl)) ?>

<ul class="detail">
    <li><?= $model->type ?></li>
    <li><?= Yii::$app->formatter->asDatetime($model->getLastChanges()) ?></li>
    <?php if ($model->isImage()) : ?>
        <li><?= $model->getOriginalImageSize($this->context->module->routes) ?></li>
    <?php endif; ?>
    <li><?= $model->getFileSize() ?></li>
    <li><?= Html::a(Module::t('main', 'Delete'), ['file/delete/', 'id' => $model->id],
            [
                'class' => 'text-danger',
                'data-message' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-id' => $model->id,
                'role' => 'delete',
            ]
        ) ?></li>
</ul>

<div class="filename"><?= $model->filename ?></div>

<?php $form = ActiveForm::begin([
    'action' => ['file/update', 'id' => $model->id],
    'enableClientValidation' => false,
    'options' => ['id' => 'control-form'],
]); ?>

    <?= $form->field($model, 'tagIds')->widget(\kartik\select2\Select2::className(), [
        'id' => 'update-image-tag',
        'maintainOrder' => true,
        'data' => ArrayHelper::map(Tag::find()->all(), 'id', 'name'),
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10,
            // нельзя создавать теги с числовым именем
            'createTag' => new \yii\web\JsExpression("function (params) {
                if (/^\d+$/.test(params.term)) {
                    return null;
                }
                return {id: params.term, text: params.term};
            }"),
        ],
    ]) ?>

    <?php if ($model->isImage()) : ?>
        <?= $form->field($model, 'alt')->textInput(['class' => 'form-control input-sm']); ?>
    <?php endif; ?>

    <?= $form->field($model, 'description')->textarea(['class' => 'form-control input-sm']); ?>

    <?php if ($model->isImage()) : ?>
        <div class="form-group<?= $strictThumb ? ' hidden' : '' ?>">
            <?= Html::label(Module::t('main', 'Select image size'), 'image', ['class' => 'control-label']) ?>

            <?= Html::dropDownList('url', $model->getThumbUrl($strictThumb), $model->getImagesList($this->context->module), [
                'class' => 'form-control input-sm'
            ]) ?>
            <div class="help-block"></div>
        </div>
    <?php else : ?>
        <?= Html::hiddenInput('url', $model->url) ?>
    <?php endif; ?>

    <?= Html::hiddenInput('id', $model->id) ?>

    <?= Html::button(Module::t('main', 'Insert'), ['id' => 'insert-btn', 'class' => 'btn btn-primary btn-sm']) ?>

    <?= Html::submitButton(Module::t('main', 'Save'), ['class' => 'btn btn-success btn-sm']) ?>

    <?php if ($message = Yii::$app->session->getFlash('mediafileUpdateResult')) : ?>
        <div class="text-success"><?= $message ?></div>
    <?php endif; ?>
<?php ActiveForm::end(); ?>
