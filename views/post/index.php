<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <img src="/photos/passport5734.png" height="100" width="100">
    <!--img src="C:\Users\bgdha\Desktop\instagram/photos/shoes01.jpg" height="100" width="100"-->
    <!--img src="<?php //Yii::$app->request->baseUrl ?>/photos/shoes01.jpg" height="100" width="100"-->

    <!--p>
        <?php // Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p-->
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'post_id',
            'user.username',
            'caption',
            //'image_url:img',
            [
                'attribute' => 'image_url',
                'format' => 'html',
                'label' => 'Picture',
                'value' => function($data){
                    return Html::img($data->image_url, ['alt' => 'Picture']);                 
                },
            ],            
            'date_posted:date:Date Posted',

            //['class' => 'yii\grid\ActionColumn'], 

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}'            
            ], 

        ],
    ]); ?>


</div>
