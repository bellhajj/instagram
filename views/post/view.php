<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Likes;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->post_id;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <!--h1><?php// Html::encode($this->title) ?></h1-->

    <?php if($model->checkLike($model->user_id, $model->post_id)) {  ?>    
    <p>    
    <?= Html::button('Unlike', ['class' => 'btn btn-warning', 'onclick' => 'f2()']) ?>     
    </p>
    <?php } else { ?>
    <p>    
    <?= Html::button('Like', ['class' => 'btn btn-primary', 'onclick' => 'f1()']) ?>
    </p>
    <?php } ?>    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.username',
            'caption',
            'image_url:url',
            'date_posted:date',
            //'like_count',
            [
                'attribute' => 'like_count',
                //'format' => 'html',
                'label' => 'Like Count',
                'value' => function($data){
                    return Likes::calculateLikeCount($data->post_id);                
                },
            ],            
        ],
    ]) ?>

    <p>
        <?= Html::a('Comment', ['comment/create', 'id' => $model->post_id], ['class' => 'btn btn-success']) ?>
    </p> 

</div>

<script>

function f2(){
    $.ajax({        
        type: 'POST',
        url:  '/likes/unlike',
        data: {
            id: <?php echo $model->post_id ?>,
            user: <?php echo $model->user_id ?>
        }, success: function(res) {   
            console.log("Success"); 
            location.reload(true);           
        }, error: function(res) {
            console.log("server error");
        }
    });
    }

    function f1(){
    $.ajax({        
        type: 'POST',
        url:  '/likes/like',
        data: {
            id: <?php echo $model->post_id ?>,
            user: <?php echo $model->user_id ?>
        }, success: function(res) {                                
            console.log("Success");  
            location.reload(true);         
        }, error: function(res) {
            console.log("server error");
        }
    });
    }   

</script>
