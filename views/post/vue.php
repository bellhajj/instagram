<?php
use app\models\Users;
use app\models\Likes;
use app\models\Post;
use app\models\Comment;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Post';
?>
<div class="container">
   <div class="row">
    <div style="border: 1px #A0A0A0 solid; margin-bottom: 20px" class="col-sm-6">        
          <img src=<?= "/". $model->image_url ?> alt=<?= $model->caption ?> class="img-responsive">
          <div class="row" style="padding: 20px 10px">           
            <div class="col-sm-4">
            <?php if(Post::checkLike($model->user_id, $model->post_id)) {  ?>     
                <button type="button" class="btn btn-success" onclick="f2()">Unlike</button>                
            <?php } else { ?>
                <button type="button" class="btn btn-primary" onclick="f1()">Like</button>
            <?php } ?> 
            </div>
          </div>
          <div class="row" style="padding-left: 10px; padding-top: 5px">
            <div class="col-sm-4">
                <strong><?= Likes::calculateLikeCount($model->post_id) ?> likes</strong>
            </div>
          </div>        
          
          <div class="caption" style="padding-left: 10px; padding-top: 5px">            
            <p><?= $model->caption ?></p>
          </div>        
    </div>
    <div style="margin-bottom: 20px" class="col-sm-6">
        
    </div>
   </div>  
      
    <?php foreach($comment as $key=>$value) { ?>
    <div class="well well-lg" style="width: 50%;">
        <p><?= $comment[$key]->date_posted ?></p>
        <p style="color: blue"><?= Users::find()->where(['user_id' => $comment[$key]->user_id])->one()->username ?></p> 
        <hr>
        <p style="font-size: 20px"><?= $comment[$key]->text ?></p>
    </div>
    <?php } ?>
    
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
