<?php
use app\models\Users;
use app\models\Likes;
use app\models\Post;
use app\models\Comment;
use app\models\Follower;
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Profile';
?>


<div class="container">
  <div class="row">
    <div class="col-sm-4">
        <img src=<?= "/". $model->profile_picture_url ?> class="img-circle img-responsive" alt="My picture">
    </div>
    <div class="col-sm-8">
        <div class="row" style="padding-bottom: 25px">
          <?php if(Yii::$app->user->identity->user_id !== $model->user_id) { ?>
            <?php if(Users::checkFollow($model->user_id)) {  ?>
                <div class="col-sm-3"><button type="button" class="btn btn-success" onclick="f2()">Unfollow <?= Users::find()->where(['user_id' => $model->user_id])->one()->username ?></button></div>
            <?php } else { ?>
                <div class="col-sm-3"><button type="button" class="btn btn-primary" onclick="f1()">follow <?= Users::find()->where(['user_id' => $model->user_id])->one()->username ?></button></div>
            <?php } ?>
          <?php } ?>
        </div>
        <div class="row" style="padding-bottom: 25px">
            <div class="col-sm-3"><strong><?= Post::find()->where(['user_id' => $model->user_id])->count() ?></strong> Post</div>
            <div class="col-sm-3"><strong><?= Follower::find()->where(['user_id' => $model->user_id])->count() ?></strong> follower</div>
            <div class="col-sm-3"><strong><?= Follower::find()->where(['user_id_following' => $model->user_id])->count() ?></strong> following</div>
        </div>  
        <div class="row" style="padding-bottom: 25px">            
            <div class="col-sm-3"><strong><?= $model->first_name ?></strong></div>
        </div>
        <div class="row">
            <div class="col-sm-3"><?= $model->bio ?></div>
        </div> 
    </div>    
  </div>
  <hr>
  <?php
  $allPost = Post::find()->where(['user_id' => $model->user_id])->all();      
  $j = 0;
  ?>  
         <div class="row">     
         <?php foreach($allPost as $key=>$value) {  ?>  
            <?php if($j < 3) { ?>   
              <div class="col-sm-4">
                  <div class="thumbnail">                       
                       <img src=<?="/".$allPost[$key]->image_url ?>  >      
                            <div class="caption"></div> 
                            <?= Html::a('View', ['/comment/create', 'id' => $allPost[$key]->post_id], ['class'=>'btn btn-link']) ?>                           
                  </div>
              </div>
            <?php } else {  ?> 
                $j = 0;
                break;
            <?php } ?>
          <?php } ?>
         </div>        
 
<script>

function f2(){
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

    function f1(){
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