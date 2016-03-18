<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItinerarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mi itinerario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itinerary-index animated fadeInDown">

<div class="ibox-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= 
        \yii2fullcalendar\yii2fullcalendar::widget(array('events' => $events,));
    ?> 
    </div>
    <br>

    <div class="ibox-content">
    <p><h2>Mis eventos</h2></p>

    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'iFkTblEvent.vc_EventName',
                'iFkTblEvent.dt_EventStart',
                'iFkTblEvent.dt_EventEnd',
                ['class' => yii\grid\ActionColumn::className(), 'template' => '{view} {delete}']
            ],
            'emptyText' => 'You dont have events'
        ]);
    ?>
    
    <p>
        <?= Html::a('Agregar evento', ['/cat-event/index'], ['class' => 'btn btn-success']) ?>
    </p>
    </div>
    
</div>
