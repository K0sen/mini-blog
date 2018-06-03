<?php

use frontend\components\CommentTree;

/* @var $post frontend\models\Blog */
/* @var $comments frontend\models\Comments */

?>

<div class="comments">
<?php foreach ($comments as $comment)
    if ($comment['parent_id'] == 0)
        CommentTree::drawBranch($comment, $comments, $post['allow_comments']);
?>
</div>

<?php if (!Yii::$app->user->isGuest && $post['allow_comments'] == 1) : ?>
    <div class="add_comment"><button class="btn btn-info" >Add a comment</button></div>

<?php endif; ?>
