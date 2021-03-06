<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <!--h1><?php //Html::encode($this->title) ?></h1-->

    <!--p>
        <?php //Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'comment_id',
            //'user_id',
            'user.username',
            //'post_id',
            'post.image_url',
            'text',
            'date_posted:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
