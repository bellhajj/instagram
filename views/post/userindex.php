<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'post_id',
            //'user.username',
            'caption',
            //'image_url:img',
            [
                'attribute' => 'image_url',
                //'format' => 'html',
                'label' => 'Picture',
                'value' => function($data){
                    return Html::img($data->image_url, ['alt' => 'Picture']);                 
                },
            ],            
            'date_posted:date:Date Posted',

            //['class' => 'yii\grid\ActionColumn'], 

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {delete}'            
            ], 

        ],
    ]); ?>


</div>
