<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $comments_model frontend\models\Comments */
/* @var $parent_id frontend\models\Comments */
/* @var $post_id frontend\models\Comments */

$form = ActiveForm::begin([
    'action' =>['comment/send'],
    'options' => ['class' => 'form-inline comment_send'],
]);
echo $form->field($comments_model, 'comment')->textArea(['rows' => 5]);
echo $form->field($comments_model, 'blog_id')->hiddenInput(['value'=> $post_id])->label(false);
echo $form->field($comments_model, 'parent_id')->hiddenInput(['value'=> $parent_id])->label(false);
echo $form->field($comments_model, 'verifyCode')->widget(Captcha::className(), [
    'captchaAction' => 'site/captcha',
    'template' => '<div><div>{image}</div><div>{input}</div></div>',
]);
echo Html::button('X', ['class' => 'btn btn-danger comment_send_close']);
echo Html::submitButton('Comment', ['class' => 'btn btn-info']);
ActiveForm::end();
?>