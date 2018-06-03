<?php

use yii\helpers\Html;
use common\models\User;

/* @var $this yii\web\View */
/* @var $post frontend\models\Blog */
/* @var $comments_model yii\web\View */

$username = User::findIdentity($post['user_id'])->username;
$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => $username . ' Posts', 'url' => ['blog-list', 'id' => $post['user_id']]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $blog_comments = isset($comments[$post['id']]) ? $comments[$post['id']] : null; ?>
<div class="post">
    <?= $this->render('_post', [
        'post' => $post,
        'comments' => $blog_comments,
        'comments_model' => $comments_model
    ]) ?>
</div>

