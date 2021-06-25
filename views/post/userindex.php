<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Posts';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jumbotron">
    
    <p>
        <?= Html::a('Create Post', ['/post/create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
