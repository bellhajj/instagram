<?php

namespace app\controllers;

use Yii;
use app\models\Likes;
use app\models\LikesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Post;
use app\models\Users;

/**
 * LikesController implements the CRUD actions for Likes model.
 */
class LikesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionLike(){

        $postData =  Yii::$app->request->post();
        $like = new Likes();
        $postmodel = Post::findIdentity($postData['id']);
        $usermodel = $postData['user'];
        if(Yii::$app->request->isAjax){  
            $like->user_id = Yii::$app->user->identity->user_id;
            $like->post_id = $postmodel->post_id;
            $like->user_id_liking = $usermodel;            
            if($like->save(false)){ 
                return $this->render('//post/view', ['model' => $postmodel]);
            }            
        }
    }

    public function actionUnlike(){

        $postData =  Yii::$app->request->post();             
        $id =  $postData['id'];   //id of post i like       
        $usermodel = Users::findIdentity($postData['user']);   //User i liked his post
        $postmodel = Post::findIdentity($id);
        if(Yii::$app->request->isAjax){      
             $user_logged_in = Yii::$app->user->identity->user_id; //currently logged in user
             $like_id = Likes::getLikeID($id, $user_logged_in, $usermodel->user_id)->like_id;
             //var_dump($like_id);      
             $this->findModel($like_id)->delete();
            return $this->render('//post/view', ['model' => $postmodel]);
        }
    }

    /**
     * Lists all Likes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LikesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Likes model.
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
     * Creates a new Likes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Likes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->like_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Likes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->like_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Likes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Likes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Likes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Likes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }   
}
