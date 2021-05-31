<?php

namespace app\controllers;

use Yii;
use app\models\Follower;
use app\models\FollowerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Users;

/**
 * FollowerController implements the CRUD actions for Follower model.
 */
class FollowerController extends Controller
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

    public function actionFollow(){
        $postData =  Yii::$app->request->post();
        $follower = new Follower();
        $usermodel = Users::findIdentity($postData['id']);
        if(Yii::$app->request->isAjax){            
            $follower->user_id = Yii::$app->user->identity->user_id;
            $follower->user_id_following = $usermodel->user_id;         
        if($follower->save(false)){                    
             return $this->render('//users/view', ['model' => $usermodel]);            
        } 
    }   
    }

    public function actionUnfollow(){
        $postData =  Yii::$app->request->post();             
        $id =  $postData['id'];   //id of user i like his page        
        $usermodel = Users::findIdentity($id);   //User i liked his page
        if(Yii::$app->request->isAjax){      
             $user_logged_in = Yii::$app->user->identity->user_id; //currently logged in user
             $follower_id = Follower::getFollowerID($id, $user_logged_in)->follower_id;      
             $this->findModel($follower_id)->delete();
            return $this->render('//users/view', ['model' => $usermodel]);
        }
    }

    /**
     * Lists all Follower models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FollowerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Follower model.
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
     * Creates a new Follower model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Follower();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->follower_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Follower model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->follower_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Follower model.
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
     * Finds the Follower model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Follower the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Follower::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
