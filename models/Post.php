<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $post_id
 * @property int $user_id
 * @property string|null $caption
 * @property string $image_url
 * @property string $date_posted
 *
 * @property Comment[] $comments
 * @property Users $user
 */
class Post extends \yii\db\ActiveRecord
{

    public $photos;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'photos'], 'required'],
            [['user_id'], 'integer'],
            [['date_posted'], 'safe'],
            [['caption', 'image_url'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['photos'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'caption' => 'Caption',
            'image_url' => 'Upload Image',
            'date_posted' => 'Date Posted',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'post_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }
}