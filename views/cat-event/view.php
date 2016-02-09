<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */

$this->title = $model->i_Pk_Event;
$this->params['breadcrumbs'][] = ['label' => 'Cat Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->i_Pk_Event], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->i_Pk_Event], [
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
            'i_Pk_Event',
            'i_FkTbl_User',
            'vc_EventName',
            'vc_EventAddress',
            'vc_EventCity',
            'dt_EventStart',
            'dt_EventEnd',
            'dc_EventCost',
        ],
    ]) ?>

</div>
