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
    
    <?= $form->field($model, 'image')->fileInput() ?>   
     

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
