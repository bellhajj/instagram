<?php
use app\models\Users;
use app\models\Likes;
use app\models\Post;
use app\models\Comment;
use yii\helpers\Html;

$this->title = 'Post';
?>
<div class="container">
    <div class="thumbnail">        
          <img src=<?= "/". $model->image_url ?> alt=<?= $model->caption ?> style="width:50%">
          <div class="row" style="padding: 20px 10px">           
            <div class="col-sm-4">
            <?php if(Post::checkLike($model->user_id, $model->post_id)) {  ?>     
                <button type="button" class="btn btn-success" onclick="f2()">Unlike</button>                
            <?php } else { ?>
                <button type="button" class="btn btn-primary" onclick="f1()">Like</button>
            <?php } ?>            
            <?= Html::a('Comment', ['/comment/createcomment', 'id' => $model->post_id], ['class'=>'btn btn-info']) ?>
            </div>
          </div>
          <div class="row" style="padding: 5px 10px">
            <div class="col-sm-4">
                <strong><?= Likes::calculateLikeCount($model->post_id) ?> likes</strong>
            </div>
          </div>
          <div class="row" style="padding: 5px 10px">
            <div class="col-sm-4">
                <strong><?= Users::findIdentity($model->user_id)->username ?></strong>
            </div>
          </div>
          
          <div class="caption">            
            <p><?= $model->caption ?></p>
          </div>        
    </div>  
      
    <?php foreach($comment as $key=>$value) { ?>
    <div class="well well-lg">
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
