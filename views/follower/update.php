<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Follower */

$this->title = 'Update Follower: ' . $model->follower_id;
$this->params['breadcrumbs'][] = ['label' => 'Followers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->follower_id, 'url' => ['view', 'id' => $model->follower_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="follower-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
