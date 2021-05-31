<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Likes */

$this->title = 'Create Likes';
$this->params['breadcrumbs'][] = ['label' => 'Likes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="likes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
