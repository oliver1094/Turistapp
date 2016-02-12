<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EvtMap */

$this->title = $model->i_Pk_Map;
$this->params['breadcrumbs'][] = ['label' => 'Evt Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-map-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->i_Pk_Map], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->i_Pk_Map], [
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
            'i_Pk_Map',
            'i_FkTbl_Event',
            'vc_Latitude',
            'vc_Longitude',
        ],
    ]) ?>

</div>
