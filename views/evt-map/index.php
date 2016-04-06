<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EvtMapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Evt Maps');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-map-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Evt Map'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'i_Pk_Map',
            'i_FkTbl_Event',
            'vc_Latitude',
            'vc_Longitude',
            'vc_EventTag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
