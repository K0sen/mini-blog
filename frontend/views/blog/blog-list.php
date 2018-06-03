<?php

use yii\helpers\Html;
use common\models\User;

/* @var $this yii\web\View */
/* @var $posts yii\web\View */
/* @var $comments_model yii\web\View */

$this->title = User::findIdentity(Yii::$app->request->get('id'))->username . ' Posts';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php foreach ($posts as $post) :
    $blog_comments = isset($comments[$post['id']]) ? $comments[$post['id']] : null;
    ?>
    <div class="post">
        <?= $this->render('_post', [
            'post' => $post,
            'comments' => $blog_comments,
            'comments_model' => $comments_model
        ]) ?>
        <hr>
    </div>
<?php endforeach; ?>
