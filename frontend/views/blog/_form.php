<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Blog */
/* @var $form yii\widgets\ActiveForm */
/* @var $upload frontend\models\UploadForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'allow_comments')->checkbox() ?>

    <label for="blog__add_img"><input type="checkbox" class="blog__add_img"> Add Image</label>

    <div class="blog__upload_img">
        <?= $form->field($upload, 'imageFile')->fileInput(['class' => 'file']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
