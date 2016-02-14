<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;

/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */

$this->title = $model->i_Pk_Event;
$this->params['breadcrumbs'][] = ['label' => 'Cat Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (!empty ($model->evtMaps)): ?>
<div class="col-md-6">
<?php endif ?>
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
</div>
<?php if (!empty ($model->evtMaps)): ?>
<div class="col-md-6">
<div>
    <?php
        $lat;
        $lng;
        if(!empty ($model->evtMaps)){
            foreach($model->evtMaps as $evtMap){
                $lat = (float)$evtMap->vc_Latitude;
                $lng = (float)$evtMap->vc_Longitude;
            }
            $coord = new LatLng(['lat' => $lat, 'lng' => $lng ]);
            $map = new Map([
                'center' => $coord,
                'zoom' => 13,
            ]);    
            $marker = new Marker([
                'position' => $coord,
                'title' => $model->vc_EventName,
            ]);
            // Add marker to the map
            $map->addOverlay($marker);    
            echo $map->display();    
        }


        
    ?>
</div>
</div>
<?php endif ?>
