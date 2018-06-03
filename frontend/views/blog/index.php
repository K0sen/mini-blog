<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $pagination yii\web\View */
/* @var $posts yii\web\View */
/* @var $comments_model yii\web\View */

$this->title = 'Mini-blog';

?>

<?php if (empty($posts)) : ?>
    There is no post created. Signup\login and create one.
<?php endif; ?>

<?php foreach ($posts as $post) :
    $blog_comments = isset($comments[$post['id']]) ? $comments[$post['id']] : null;
    ?>
    <div class="post">
        <?= $this->render('_post', [
            'post' => $post,
            'comments' => $blog_comments,
            'comments_model' => $comments_model
        ]); ?>
        <hr>
    </div>
<?php endforeach; ?>

<?= LinkPager::widget([
    'pagination' => $pagination,
    'lastPageLabel'=>'»',
    'firstPageLabel'=>'«',
    'prevPageLabel' => '<',
    'nextPageLabel' => '>',
]) ?>


