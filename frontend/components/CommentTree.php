<?php

namespace frontend\components;

use Yii;
use yii\helpers\Html;
use common\models\User;

/**
 * Helper for generating tree of comments
 * P.S. Don't realize yet how to generate a tree in view without helper functions
 * Class CommentTree
 * @package frontend\components
 */
class CommentTree
{
    /**
     * Generate single branch of comments
     * @param $comment
     * @param $arr
     */
    public static function drawBranch($comment, $arr, $allow_comments)
    {
        echo Html::beginTag('div', ['class' => 'comment']);
        self::drawComment($comment, $allow_comments);
        $n = $comment['id'];
        $childs = array_filter($arr, function($var) use ($n) {
            return $var['parent_id'] == $n;
        });
        if ($childs) {
            foreach ($childs as $child) {
                self::drawBranch($child, $arr, $allow_comments);
            }
        }
        echo Html::endTag('div');
    }

    /**
     * Generate a single comment
     * @param $comment
     */
    public static function drawComment($comment, $allow_comments)
    {
        echo Html::input('hidden', 'comment__id', $comment['id'], ['class' => 'comment__id']);

        echo Html::beginTag('div', ['class' => 'comment__author']);
        echo 'Author: <b>' . User::findIdentity($comment['user_id'])->username . '</b>';
        echo Html::endTag('div');

        echo Html::beginTag('div', ['class' => 'comment__date']);
        echo date("d/m/y H:i:s", $comment['created_at']);
        echo Html::endTag('div');

        echo Html::beginTag('div', ['class' => 'comment__text']);
        echo $comment['comment'];
        echo Html::endTag('div');

        if (!Yii::$app->user->isGuest && $allow_comments == 1) {
            echo Html::beginTag('div', ['class' => 'comment__reply add_comment']);
            echo 'Reply to the comment';
            echo Html::endTag('div');
        }

    /** Html version
        <input type="hidden" class="comment__id" name="comment__id", value="<?= $comment['id'] ?>">
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
     */
    }
}