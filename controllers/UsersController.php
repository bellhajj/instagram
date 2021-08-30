<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\UploadedFile;
use app\models\Follower;
use app\models\Post;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete'],
                'rules' => [                   
                    [
                        'actions' => ['index', 'view', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity->user_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProfile($user){

        $model = Users::find()->where(['user_id' => $user])->one();
        $postCount = Post::find()->where(['user_id' => $user])->count();
        $followerCount = Follower::find()->where(['user_id' => $user])->count();
        $followingCount = Follower::find()->where(['user_id_following' => $user])->count();
        $post_all =  Post::find()->where(['user_id' => $user])->all();
        return $this->render('profile', [
            'model' => $model, 
            'postCount' => $postCount,
            'followerCount' => $followerCount,
            'followingCount' => $followingCount,
            'post_all' => $post_all
        ]);
    }
   

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {
            $model->upload = UploadedFile::getInstance($model, 'upload');
            if ($model->validate()) {                           
            if($model->upload !== null){
                $rnd = rand(0,9999);
                $filePath = 'upload/'.$model->upload->baseName.$rnd.'.'.$model->upload->extension;              
                if ($model->upload->saveAs($filePath)) { //Saves in the upload folder
                     $model->profile_picture_url = $filePath;
                }  
            }
            if ($model->save(false)) {          
                Yii::$app->session->setFlash('success', 'Your account was created successfully. 
                Use your credential to login');           
                //return $this->goHome();
                return $this->redirect(['/site/login']);
            }
            }  
        }
            return $this->render('create', ['model' => $model,]);     
    }

       /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttxception if the model cannot be found
     */
    public function actionDelete($id)
    {
        Yii::$app->user->logout();        
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Your account was deleted successfully');
        return $this->goHome();        
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
