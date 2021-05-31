<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Follower */

$this->title = 'Create Follower';
$this->params['breadcrumbs'][] = ['label' => 'Followers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="follower-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
