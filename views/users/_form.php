<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4 panel panel-default">
        <h2 class="text-center">Create An Account</h2>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="form-group">	         
          <?= $form->field($model, 'first_name', ['inputOptions' => ['placeholder' => 'First Name' ],])->textInput(['class'=>'form-control', 'autofocus' => true])->label(false); ?>                          
	    </div>
        <div class="form-group">	         
          <?= $form->field($model, 'last_name', ['inputOptions' => ['placeholder' => 'Last Name' ],])->textInput(['class'=>'form-control', 'autofocus' => true])->label(false); ?>                          
	    </div>
        <hr>
        <div class="form-group">	         
          <?= $form->field($model, 'username', ['inputOptions' => ['placeholder' => 'Username' ],])->textInput(['class'=>'form-control', 'autofocus' => true])->label(false); ?>                          
	    </div>
        <div class="form-group">	         
          <?= $form->field($model, 'email', ['inputOptions' => ['placeholder' => 'Email' ],])->textInput(['class'=>'form-control', 'autofocus' => true])->label(false); ?>                          
	    </div>
        <div class="form-group">	         
          <?= $form->field($model, 'password', ['inputOptions' => ['placeholder' => 'Password' ],])->passwordInput(['class'=>'form-control', 'autofocus' => true])->label(false); ?>                          
	    </div>
        <div class="form-group">	         
          <?= $form->field($model,'date_of_birth')->widget(yii\jui\DatePicker::className(),['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control', 'placeholder' => 'Date of Birth' ]])->label(false); ?>                          
	    </div>
        <hr>
        <div class="form-group">	         
        <?= $form->field($model, 'bio')->textArea(['maxlength' => true, 'rows' => '6', 'cols' => '3'])->label(false); ?>                         
	    </div>
        <hr>
        <div class="form-group">	         
        <?= $form->field($model, 'upload')->fileInput() ?>                        
	    </div>
        <div class="form-group">
            <div class="col-md-offset-4 col-md-4" style="margin-bottom: 10px">
                <?= Html::submitButton('create', ['class' => 'btn btn-success btn-block ',  'name' => 'login-button']) ?>                
            </div>
          </div>
        <?php ActiveForm::end(); ?>        
    </div>
    <div class="col-md-4">
    </div>
</div>