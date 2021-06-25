<?php
use app\models\Users;
use app\models\Likes;
use app\models\Post;
use yii\helpers\Html;

$this->title = 'Home';
?>

<div class="container">
 <?php foreach($model as $key=>$value) { ?>
    
          <div style="border: 1px #A0A0A0 solid; width: 50%; margin-bottom: 20px">

          <div class="row">
            <div class="col-sm-4">
                <strong><?= Html::a(Users::findIdentity($model[$key])->username, ['/users/profile', 'user' => $model[$key]->user_id], ['class'=>'btn btn-link']) ?></strong>
            </div>
          </div>

          <img src=<?="/".$model[$key]->image_url ?> alt=<?= $model[$key]->caption ?> class="img-responsive">

          <div class="row" style="padding-left: 10px; padding-top: 5px">           
            <div class="col-sm-4">
            <?php if(Post::checkLike($model[$key]->user_id, $model[$key]->post_id)) {  ?>     
                <button type="button" class="btn btn-success" onclick="f2( <?php echo $model[$key]->post_id ?> , <?php echo $model[$key]->user_id ?> )">Unlike</button>                
            <?php } else { ?>
                <button type="button" class="btn btn-primary" onclick="f1( <?php echo $model[$key]->post_id ?> , <?php echo $model[$key]->user_id ?>  )">Like</button>                
            <?php } ?>            
            <?= Html::a('Comment', ['/comment/create', 'id' => $model[$key]->post_id], ['class'=>'btn btn-info']) ?>
            </div>
          </div>
          <div class="row" style="padding-left: 10px; padding-top: 5px">
            <div class="col-sm-4">
                <strong><?= Likes::calculateLikeCount($model[$key]->post_id) ?> likes</strong>
            </div>
          </div>         
          
          <div class="caption" style="padding-left: 10px; padding-top: 5px">            
            <p><?= $model[$key]->caption ?></p>
          </div>        
          </div>

 <?php } ?>

</div>

<script>

function f2(p, u){
    $.ajax({        
        type: 'POST',
        url:  '/likes/unlike',
        data: {
            id: p,
            user: u
        }, success: function(res) {   
            console.log("Success"); 
            location.reload(true);           
        }, error: function(res) {
            console.log("server error");
        }
    });
    }

    function f1(p, u){
    $.ajax({        
        type: 'POST',
        url:  '/likes/like',
        data: {
            id: p,
            user: u
        }, success: function(res) {                                
            console.log("Success");  
            location.reload(true);         
        }, error: function(res) {
            console.log("server error");
        }
    });
    }   

</script>
