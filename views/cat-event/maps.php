<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Itinerary;
use app\models\EvtComment;
use app\controllers\CatEventController;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;   
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */
?>

<?php /* Validates if there is a map */ 
if (!empty ($model->evtMaps)): ?>

    <?php $eventVariables = '
        var eventLat = '. $model->evtMaps[0]->vc_Latitude .';
        var eventLng = '. $model->evtMaps[0]->vc_Longitude .';
        var eventTag = "'. $model->evtMaps[0]->vc_EventTag .'";
    ';
    $this->registerJs($eventVariables, View::POS_HEAD, 'eventVariables')?>

    <?php /* Validates if there is a transport marker */ 
    if (!empty($model->evtMaps[0]->vc_LatitudeTransport)) : ?>

        <?php $transportVariables ='
            transportLat = ' . $model->evtMaps[0]->vc_LatitudeTransport . ';
            transportLng = '. $model->evtMaps[0]->vc_LongitudeTransport .';
            var transportTag = "'. $model->evtMaps[0]->vc_TransportTag .'";
        ';
        $this->registerJs($transportVariables, View::POS_HEAD, 'transportVariables')?>

    <?php else : ?>

        <?php $transportNull ='    
            transportLat = "";
            transportLng = "";
        ';
        $this->registerJs($transportNull, View::POS_HEAD, 'transportNull')?>

    <?php endif ?>
    
<div class="col-md-6">
<br>
<div class="ibox-content animated fadeInDown" style="display: block;">

<p>
    <?php /* Validates if the user is allowed to change this map */ 
    if (CatEventController:: allowed($model->i_Pk_Event)) : ?>

        <?= Html::a(Yii::t('app', 'Modificar mapa'), 
            ['evt-map/update', 'id' =>$model->evtMaps[0]->i_Pk_Map],
            ['class' => 'btn btn-primary']) 
        ?>

        <?= Html::a(Yii::t('app', 'Eliminar mapa'),
            ['evt-map/delete', 'id' =>$model->evtMaps[0]->i_Pk_Map], 
            [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', '¿Seguro que deseas eliminar el mapa?'),
                    'method' => 'post',
                ],
            ]
        )?>

    <?php endif ?>   

    <?= Html::button(Yii::t('app', 'Ruta'), ['class' => 'btn btn-primary', 'id'=>"route"]) ?>
    <?= Html::button(Yii::t('app', 'Ubicación actual'), ['class' => 'btn btn-primary', 'id'=>"currentLocation"]) ?>

<div id = "text"><p>Buscando...<span id="status"></span></p></div>

</p>
<div id="viewMap" style="width:500px;height:380px;">     
</div>
</div>
</div>

<?php endif ?>