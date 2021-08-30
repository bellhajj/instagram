<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

    <!--h1><?php // Html::encode($this->title) ?></h1-->
   
    <?php if($model->checkFollow($model->user_id)) {  ?>
    <p>    
    <?= Html::button('Unfollow User', ['class' => 'btn btn-danger', 'onclick' => 'unfollow()']) ?>      
    </p>
    <?php } else { ?>
    <p>    
    <?= Html::button('Follow User', ['class' => 'btn btn-primary', 'onclick' => 'follow()']) ?>
    </p>
    <?php } ?>
     

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            'username',
            'email:email',            
            'first_name',
            'last_name',
            'date_of_birth:date',
            'profile_picture_url:url',
            'bio',            
        ],
    ]) ?>

</div>
<script>

function unfollow(){
    $.ajax({        
        type: 'POST',
        url:  '/follower/unfollow',
        data: {
            id: <?php echo $model->user_id ?>
        }, success: function(res) {   
            console.log("Success"); 
            location.reload(true);           
        }, error: function(res) {
            console.log("server error");
        }
    });
    }

    function follow(){
    $.ajax({        
        type: 'POST',
        url:  '/follower/follow',
        data: {
            id: <?php echo $model->user_id ?>
        }, success: function(res) {                                
            console.log("Success");  
            location.reload(true);         
        }, error: function(res) {
            console.log("server error");
        }
    });
    }   

</script>