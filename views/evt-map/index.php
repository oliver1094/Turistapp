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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            // 'vc_TransportTag',
            // 'vc_LatitudeTransport',
            // 'vc_LongitudeTransport',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
