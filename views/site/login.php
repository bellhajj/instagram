<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<?php if(Yii::$app->session->hasFlash('success')) { ?>
            <div class="alert alert-info text-center">
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
  <?php } ?>
</div>

<div class="row">

  <div class="col-md-4">
  </div>
  <div class="col-md-4 panel panel-default" >
  <h2 class="text-center">Instagram</h2> 

      <?php $form = ActiveForm::begin([
        'id' => 'login-form',                
        ]); ?>
	    <div>
	      <div class="form-group">	         
          <?= $form->field($model, 'email', ['inputOptions' => ['placeholder' => 'Enter Your Email' ],])->textInput(['class'=>'form-control', 'autofocus' => true])->label(false); ?>                          
	      </div>
          <div class="form-group">
          <?= $form->field($model, 'password', ['inputOptions' => ['placeholder' =>'Enter Your Password'],])->passwordInput(['class'=>'form-control'])->label(false); ?>              
	      </div>
	      <div class="form-group">
            <div class="col-md-offset-4 col-md-4">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block ',  'name' => 'login-button']) ?>                
            </div>
          </div>	
	    </div>   
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8 text center">
        <p>Don't have an account? <?= Html::a('Signup', ['/users/create']) ?></p>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
  </div>
  <div class="col-md-4">
  
  </div>
</div>
