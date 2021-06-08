<?php
use app\models\Users;
use app\models\Likes;
use app\models\Post;
use yii\helpers\Html;

$this->title = 'Home';
?>

<div class="container">
 <?php foreach($model as $key=>$value) { ?>
    
      <div class="thumbnail">       
          <img src=<?="/".$model[$key]->image_url ?> alt=<?= $model[$key]->caption ?> style="width:50%" class="img-responsive">
          <div class="row" style="padding: 20px 10px">           
            <div class="col-sm-4">
                <?= Html::a('View', ['/likes/pagelikecomment', 'post' => $model[$key]->post_id], ['class'=>'btn btn-danger']) ?>
            </div>
          </div>
          <div class="row" style="padding: 5px 10px">
            <div class="col-sm-4">
                <strong><?= Likes::calculateLikeCount($model[$key]->post_id) ?> likes</strong>
            </div>
          </div>
          <div class="row" style="padding: 5px 10px">
            <div class="col-sm-4">
                <strong><?= Html::a(Users::findIdentity($model[$key])->username, ['/users/profile', 'user' => $model[$key]->user_id], ['class'=>'btn btn-link']) ?></strong>
            </div>
          </div>
          
          <div class="caption">            
            <p><?= $model[$key]->caption ?></p>
          </div>        
      </div> 

 <?php } ?>

</div>

