<?php
use app\models\Users;
use app\models\Likes;
use app\models\Post;
use app\models\Comment;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use Carbon\Carbon;

$this->title = 'Post';
?>

<div class="container" id="contain">
    <div class="row">
        <div class="panel panel-default col-sm-6">
            <img src=<?= "/". $model->image_url ?> alt=<?= $model->caption ?> class="img-responsive">
            <div class="row" style="padding: 20px 10px">
                <div class="col-sm-4">
                    <?php if(Post::checkLike($model->user_id, $model->post_id)) {  ?>
                    <button type="button" id="unlike" class="btn btn-success" onclick="unLikeFunction()">Unlike</button>
                    <?php } else { ?>
                    <button type="button" id="like" class="btn btn-primary" onclick="likeFunction()">Like</button>
                    <?php } ?>

                </div>
            </div>
            <div class="row" style="padding-left: 10px; padding-top: 5px">
                <div class="col-sm-4" id="count">
                    <strong><?= $likeCount ?> like</strong>
                </div>
            </div>

            <div class="caption" style="padding-left: 10px; padding-top: 5px">
                <p>
                    <span><strong><?= $user ?></strong></span>
                    <?= $model->caption ?>
                </p>
                <span><?= Carbon::create($model->date_posted)->diffForHumans() ?></span>
                <hr>
                <div class="well well-sm">
                    <?php foreach($commentsWithUsers as $key=>$value) { ?>
                    <?= Html::a($value->user->username,  ['/users/profile', 'user' => $value->user_id], ['class'=>'btn btn-link']) ?>
                    <?= $value['text'] ?>
                    <br>
                    <?php } ?>
                </div>               
            </div>
        </div>
        <div style="margin-bottom: 20px" class="col-sm-6">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($newComment, 'text')->textArea(['maxlength' => true, 'rows' => 8]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<script>
function unLikeFunction() {
    $.ajax({
        type: 'POST',
        url: '/likes/unlike',
        data: {
            id: <?php echo $model->post_id ?>,
            user: <?php echo $model->user_id ?>
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

function likeFunction() {
    $.ajax({
        type: 'POST',
        url: '/likes/like',
        data: {
            id: <?php echo $model->post_id ?>,
            user: <?php echo $model->user_id ?>
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