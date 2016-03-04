<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EvtComment */

$this->title = $model->i_FkTbl_Event;
$this->params['breadcrumbs'][] = ['label' => 'Evt Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'i_FkTbl_Event' => $model->i_FkTbl_Event, 'i_FkTbl_User' => $model->i_FkTbl_User], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'i_FkTbl_Event' => $model->i_FkTbl_Event, 'i_FkTbl_User' => $model->i_FkTbl_User], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'i_FkTbl_Event',
            'i_FkTbl_User',
            'txt_EventComment:ntext',
            'i_Score',
        ],
    ]) ?>

</div>
