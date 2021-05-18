<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "follower".
 *
 * @property int $user_id
 * @property int $follower_id
 *
 * @property Users $user
 */
class Follower extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'follower';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['follower_id'], 'required'],
            [['follower_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'follower_id' => 'Follower ID',
        ];
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
