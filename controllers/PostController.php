<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Likes;
use app\models\Comment;
use yii\filters\AccessControl;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'user', 'homee'],
                'rules' => [                   
                    [
                        'actions' => ['index', 'view', 'create', 'user', 'homee'],
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHomee(){
        
        $model = Post::find()->joinWith(['user'])->all();  
        $commentsWithUsers = Comment::find()->joinWith(['user','post'])->all();      
        return $this->render('homee', ['model' => $model, 'commentsWithUsers'=>$commentsWithUsers]);
    }

    public function actionUser(){

        $searchModel = new PostSearch();       
        $dataProvider = $searchModel->searchUserPost(Yii::$app->request->queryParams, Yii::$app->user->identity->user_id);

        return $this->render('userindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        if ($model->load(Yii::$app->request->post())){
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->user_id =  Yii::$app->user->identity->user_id;
            if($model->validate()){
                if($model->image !== null && $model->user_id !== null){                   
                    
                    $rnd = rand(0,9999);
                    $filePath = 'photos/'.$model->image->baseName.$rnd.'.'.$model->image->extension;
                    if($model->image->saveAs($filePath)){
                        $model->image_url = $filePath;
                    }
                }
                if($model->save(false)){
                   // return $this->redirect(['view', 'id' => $model->post_id]);
                   return $this->redirect(['homee']);
                }
            }
        }       

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['view', 'id' => $model->post_id]);
        } 

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
