<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Post;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php if($model->post_id === null){ ?>
    <?= $form->field($model, 'image')->fileInput() ?>
    <?php } else { ?>
    <?php $model->photos = Post::findOne($model->post_id)->image_url;         
        }
     ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'caption')->textArea(['rows' => '6']) ?> 
        </div>   
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
