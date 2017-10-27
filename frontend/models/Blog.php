<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "blog".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $title
 * @property string $text
 * @property integer $allow_comments
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $image
 *
 * @property User $user
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
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
            [['title', 'text', 'allow_comments'], 'required'],
            [['user_id', 'allow_comments', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['text'], 'string', 'max' => 10000],
            [['image'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'text' => 'Text',
            'allow_comments' => 'Allow Comments',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'image' => 'Image Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
