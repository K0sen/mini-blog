<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property integer $user_id
 * @property string $comment
 * @property integer $parent_comment
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Blog $blog
 */
class Comments extends \yii\db\ActiveRecord
{
    public $verifyCode;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'user_id', 'comment'], 'required'],
            [['blog_id', 'user_id', 'parent_comment', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string', 'max' => 200],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blog::className(), 'targetAttribute' => ['blog_id' => 'id']],
            ['verifyCode', 'captcha', 'captchaAction' => 'site/captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blog_id' => 'Blog ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'parent_comment' => 'Parent Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }


    public function findComments($posts)
    {
        $comments = [];
        foreach ($posts as $post) {
            $comments[$post['id']] = $this::find()->where(['blog_id' => $post['id']])->all();
        }

        return $comments;
    }
}
