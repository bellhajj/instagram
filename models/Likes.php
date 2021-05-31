<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property int $like_id
 * @property int $user_id
 * @property int $user_id_liking
 * @property int|null $post_id
 *
 * @property Users $user
 * @property Post $post
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_id_liking'], 'required'],
            [['user_id', 'user_id_liking', 'post_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'post_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'like_id' => 'Like ID',
            'user_id' => 'User ID',
            'user_id_liking' => 'User Id Liking',
            'post_id' => 'Post ID',
        ];
    }

    public static function calculateLikeCount($post_id){        
        return Likes::find()->where(['post_id' => $post_id])->count();
    }

     
    public static function getLikeID($post_id, $user_logged_in, $user_id_liking){
        return Likes::find()->where(['post_id'=>$post_id, 'user_id' => $user_logged_in, 'user_id_liking' => $user_id_liking])->one();
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

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['post_id' => 'post_id']);
    }
}
