<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SysComment */

$this->title = 'Update Sys Comment: ' . ' ' . $model->i_Pk_Score;
$this->params['breadcrumbs'][] = ['label' => 'Sys Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->i_Pk_Score, 'url' => ['view', 'id' => $model->i_Pk_Score]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sys-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
