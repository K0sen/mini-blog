<?php

use yii\helpers\Html;
use common\models\User;

/* @var $this yii\web\View */
/* @var $post frontend\models\Blog */

$username = User::findIdentity($post['user_id'])->username;
$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => $username . ' Posts', 'url' => ['blog-list', 'id' => $post['user_id']]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="news">
    <?= $this->render('_post', [
        'post' => $post,
    ]) ?>
</div>

