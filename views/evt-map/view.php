<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EvtMap */

$this->title = $model->i_Pk_Map;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Evt Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-map-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->i_Pk_Map], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->i_Pk_Map], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Estas seguro de que deseas eliminar este mapa?'),
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
            'vc_EventTag',
            'vc_TransportTag',
            'vc_LatitudeTransport',
            'vc_LongitudeTransport',
        ],
    ]) ?>

</div>
