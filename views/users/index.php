<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <p>
        <?php //Html::a('Delete Account', ['users/delete', 'id' => Yii::$app->user->identity->user_id], ['class' => 'btn btn-danger', 'data-method'=>'post']) ?>
        <?= Html::a('Delete Account', ['users/delete', 'id' => Yii::$app->user->identity->user_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete your account?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'user_id',
            'username',
            //'email:email',
            //'password',
            'first_name',
            'last_name',
            //'date_of_birth',
            //'profile_picture_url:url',
            //'bio',
            //'join_date',

            //['class' => 'yii\grid\ActionColumn'],

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}',            
            ],
        ],
    ]); ?>


</div>
