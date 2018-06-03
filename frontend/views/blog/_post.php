<?php

use yii\helpers\Html;
use common\models\User;

/* @var $post frontend\models\Blog */
/* @var $comments frontend\models\Comments */
/* @var $comments_model frontend\models\Comments */

?>

<input type="hidden" class="post__id" value="<?= $post['id'] ?>">
<div class="post__author">
    <?= 'Author: <b>' . User::findIdentity($post['user_id'])->username . '</b>' ?>
</div>
<div class="post__create_time">
    <?= 'Creation time: ' . date("d/m/y H:i:s", $post['created_at']) ?>
</div>
<div class="post__image">
    <?php
    if ( file_exists('uploads/pictures/' . $post['image']) && $post['image'] != "" )
        echo Html::img('@web/uploads/pictures/' . $post['image'], ['class' => 'img img-responsive']);
    else
        echo Html::img('@web/img/default_post.jpg' , ['class' => 'img img-responsive']);
    ?>
</div>
<div class="post__title">
    <a href="<?= Yii::$app->urlManager->createUrl("read/{$post['id']}"); ?>"><?= $post['title'] ?></a>
</div>
<div class="post__text">
    <?= $post['text'] ?>
    <br>
    <a href="<?= Yii::$app->urlManager->createUrl("read/{$post['id']}"); ?>" target="_blank">Read on new link</a>
</div>

<?php if ( !Yii::$app->user->isGuest && (Yii::$app->user->identity->id == $post['user_id']) ) : ?>
    <div class="post__control_panel">
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

<?php if (!empty($comments)) : ?>
    <div class="show_comments"><button class="btn btn-primary" >Show comments</button></div>
    <?= $this->render('@frontend/views/comment/comments', [
        'comments' => $comments,
        'post' => $post,
        'comments_model' => $comments_model
    ]) ?>
<?php endif; ?>



