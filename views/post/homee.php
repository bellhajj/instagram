<?php
use app\models\Users;
use app\models\Likes;
use app\models\Post;
use yii\helpers\Html;

use Carbon\Carbon;

$this->title = 'Home';
?>

<div class="container" id="contain">
    <?php 
 rsort($model);
 foreach($model as $key=>$value)  { ?>

    <div class="panel panel-default" style="width:50%">

        <div class="row">
            <div class="col-sm-4">
                <strong><?= Html::a($value->user->username, ['/users/profile', 'user' => $model[$key]->user_id], ['class'=>'btn btn-link']) ?></strong>
            </div>
        </div>

        <img src=<?="/".$model[$key]->image_url ?> alt=<?= $model[$key]->caption ?> class="img-responsive">

        <div class="row" style="padding-left: 10px; padding-top: 5px">
            <div class="col-sm-4">
                <?php if(Post::checkLike($model[$key]->user_id, $model[$key]->post_id)) {  ?>
                <button type="button" class="btn btn-success"
                    onclick="unlikeFunction( <?php echo $model[$key]->post_id ?> , <?php echo $model[$key]->user_id ?> )">Unlike</button>
                <?php } else { ?>
                <button type="button" class="btn btn-primary"
                    onclick="likeFunction( <?php echo $model[$key]->post_id ?> , <?php echo $model[$key]->user_id ?>  )">Like</button>
                <?php } ?>
                <?= Html::a('Comment', ['/comment/create', 'id' => $model[$key]->post_id, 'user'=> $model[$key]->user_id], ['class'=>'btn btn-info']) ?>
            </div>
        </div>
        <div class="row" style="padding-left: 10px; padding-top: 5px">
            <div class="col-sm-4">
                <strong><?= Likes::calculateLikeCount($model[$key]->post_id) ?> likes</strong>
            </div>
        </div>

        <div class="caption" style="padding-left: 10px; padding-top: 5px">
            <p>
                <span><strong><?= $value->user->username ?></strong></span>
                <?= $model[$key]->caption ?>
            </p>
        </div>
        <?php $j = 1 ?>
        <div class="caption" style="padding-left: 10px; padding-top: 5px">
            <?php foreach($commentsWithUsers as $key1=>$value1) { ?>
            <?php if($model[$key]->post_id === $value1->post->post_id){ ?>
            <span><strong><?= $value1->user->username ?></strong></span>
            <?= $value1['text'] ?>
            <?php $j++; ?>
            <br>
            <?php if($j > 2){ ?>
            <?= Html::a('View all Comment', ['/comment/create', 'id' => $model[$key]->post_id, 'user' => $model[$key]->user_id], ['class'=>'btn btn-link']) ?>
            <?php break; ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        </div>

        <div class="row" style="padding-left: 10px; padding-top: 10px">
            <div class="col-sm-4">
                <span><?=  Carbon::create($model[$key]->date_posted)->diffForHumans()  ?></span>
            </div>
        </div>

    </div>

    <?php } ?>

</div>

<script>
function unlikeFunction(post_id, user_id) {
    $.ajax({
        type: 'POST',
        url: '/likes/unlike',
        data: {
            id: post_id,
            user: user_id
        },
        success: function(res) {
            console.log("Success");
            $("#contain").load(location.href + " #contain");
        },
        error: function(res) {
            console.log("server error");
        }
    });
}

function likeFunction(post_id, user_id) {
    $.ajax({
        type: 'POST',
        url: '/likes/like',
        data: {
            id: post_id,
            user: user_id
        },
        success: function(res) {
            console.log("Success");
            $("#contain").load(location.href + " #contain");
        },
        error: function(res) {
            console.log("server error");
        }
    });
}
</script>