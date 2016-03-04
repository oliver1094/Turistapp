<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EvtComment */

$this->title = 'Update Evt Comment: ' . ' ' . $model->i_FkTbl_Event;
$this->params['breadcrumbs'][] = ['label' => 'Evt Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->i_FkTbl_Event, 'url' => ['view', 'i_FkTbl_Event' => $model->i_FkTbl_Event, 'i_FkTbl_User' => $model->i_FkTbl_User]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evt-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
