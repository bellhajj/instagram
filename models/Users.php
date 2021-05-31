<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $user_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string|null $profile_picture_url
 * @property string|null $bio
 * @property string $join_date
 *
 * @property Comment[] $comments
 * @property Follower $follower
 * @property Post[] $posts
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    public $upload;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    public function beforeSave($insert){
        if($insert){
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'first_name', 'last_name', 'date_of_birth'], 'required'],
            [['date_of_birth', 'join_date'], 'safe'],
            [['username', 'email', 'first_name', 'last_name', 'profile_picture_url', 'bio'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['upload'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'date_of_birth' => 'Date Of Birth',
            'profile_picture_url' => 'Profile Picture',
            'bio' => 'Bio',
            'join_date' => 'Join Date', 
            'upload' => 'Profile Picture',           
        ];
    }

    // Need to define for the interface
    public static function findIdentityByAccessToken($token, $type = null){

    }

    // Need to define for the interface
    public function getAuthkey(){

    }

    // Need to define for the interface
    public function validateAuthKey($authKey){

    }

    // Need to define for the interface
    public function getId(){
        return $this->user_id;
    }

    // Need to define for the interface
    public static function findIdentity($id){
        return Users::findOne($id);
    }

    public static function findByEmail($email){
        return Users::find()->where(['email' => $email])->one();
    }

    public function validatePassword($password){
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function checkFollow($id){
        $user_logged_in = Yii::$app->user->identity->user_id;
        if(Follower::find()->where(['user_id' => $user_logged_in])->exists()
           && Follower::find()->where(['user_id_following' => $id])->exists()){               
               return true; //Yes the logged in user is following him 
           }else{
               return false;
           }
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Follower]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollower()
    {
        return $this->hasOne(Follower::className(), ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['user_id' => 'user_id']);
    }
}
