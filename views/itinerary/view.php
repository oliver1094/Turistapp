<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Itinerary */

$this->title = $model->i_FkTbl_User;
$this->params['breadcrumbs'][] = ['label' => 'Itineraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itinerary-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<!--         Html::a('Update', ['update', 'i_FkTbl_User' => $model->i_FkTbl_User, 'i_FkTbl_Event' => $model->i_FkTbl_Event], ['class' => 'btn btn-primary']) ?>-->
        <?= Html::a('Delete', ['delete', 'i_FkTbl_User' => $model->i_FkTbl_User, 'i_FkTbl_Event' => $model->i_FkTbl_Event], [
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
            'i_FkTbl_User',
            'i_FkTbl_Event',
            'iFkTblEvent.vc_EventName',
            'iFkTblEvent.vc_EventAddress',
            'iFkTblEvent.vc_EventCity',
            'iFkTblEvent.dt_EventStart',
            'iFkTblEvent.dt_EventEnd',
            'iFkTblEvent.dc_EventCost'
        ],
    ]) ?>

</div>
