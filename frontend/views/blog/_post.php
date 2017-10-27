<?php

use yii\helpers\Html;
use common\models\User;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $post frontend\models\Blog */
/* @var $comments frontend\models\Blog */
/* @var $comments_model frontend\models\Blog */

?>

<div class="news__author">
    <?= 'Author: <b>' . User::findIdentity($post['user_id'])->username . '</b>' ?>
</div>
<div class="news__create_time">
    <?= 'Creation time: ' . date("d/m/y H:i:s", $post['created_at']) ?>
</div>
<div class="news__image">
    <?php
    if ( file_exists('uploads/pictures/' . $post['image']) && $post['image'] != "" )
        echo Html::img('@web/uploads/pictures/' . $post['image'], ['class' => 'img img-responsive']);
    else
        echo Html::img('@web/img/default_post.jpg' , ['class' => 'img img-responsive']);
    ?>
</div>
<div class="news__title">
    <a href="<?= Yii::$app->urlManager->createUrl("read/{$post['id']}"); ?>"><?= $post['title'] ?></a>
</div>
<div class="news__text">
    <?= $post['text'] ?>
    <br>
    <a href="<?= Yii::$app->urlManager->createUrl("read/{$post['id']}"); ?>" target="_blank">Read on new link</a>
</div>

<?php if (!empty($comments)) : ?>
    <div class="show_comments"><button class="btn btn-primary" >Show comments</button></div>
    <div class="comments">
    <?php foreach ($comments as $comment) : ?>
        <div class="comment">
            <div class="comment__author">
                <?= 'Author: <b>' . User::findIdentity($comment['user_id'])->username . '</b>' ?>
            </div>
            <div class="comment__date">
                <?= date("d/m/y H:i:s", $comment['created_at']) ?>
            </div>
            <div class="comment__text">
                <?= $comment['comment'] ?>
            </div>
            <div class="comment__reply">
                <a href="#">Reply to the comment</a>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!Yii::$app->user->isGuest && $post['allow_comments'] == 1 && isset($comments)) : ?>
    <div class="add_comment"><button class="btn btn-info" >Add a comment</button></div>
    <?php
    $form = ActiveForm::begin([
        'id' => 'send-form',
        'action' =>['comment/send'],
        'options' => ['class' => 'form-inline comment_send'],
        ]);
    echo $form->field($comments_model, 'comment')->textArea(['rows' => 5]);
    echo $form->field($comments_model, 'blog_id')->hiddenInput(['value'=> $post['id']])->label(false);
    echo $form->field($comments_model, 'verifyCode')->widget(Captcha::className(), [
        'captchaAction' => 'site/captcha',
        'template' => '<div><div>{image}</div><div>{input}</div></div>',
    ]);
    echo Html::submitButton('Comment', ['class' => 'btn btn-info']);
    ActiveForm::end();
    ?>
<?php endif; ?>

<?php if ( !Yii::$app->user->isGuest && (Yii::$app->user->identity->id == $post['user_id']) ) : ?>
<div class="news__control_panel">
    <div class="control_panel__text">It's is my post</div>
    <?= Html::a('Update', ['update', 'id' => $post['id']], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $post['id']], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</div>
<?php endif; ?>

