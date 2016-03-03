<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Itinerary;
use app\models\EvtComment;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;   

/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */
?>

<?php if (!empty ($model->evtMaps)): ?>

<?php
    $this->registerJsFile('http://maps.googleapis.com/maps/api/js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php $this->registerJs('


    var map;
    var myCenter;
    var origin = "";
    var destination;
    var serviceRoutes = new google.maps.DirectionsService();
    var directionsRenderer;

    var transportLocation;

    var transportLat;
    var transportLng;

    var eventLat = '. $model->evtMaps[0]->vc_Latitude .';
    var eventLng = '. $model->evtMaps[0]->vc_Longitude .';

')?>

<?php if (!empty($model->evtMaps[0]->vc_LatitudeTransport)) : ?>

<?php $this->registerJs('
    transportLat = ' . $model->evtMaps[0]->vc_LatitudeTransport . ';
    transportLng = '. $model->evtMaps[0]->vc_LongitudeTransport .';
')?>

<?php else : ?>
<?php $this->registerJs('    
        transportLat = "";
        transportLng = "";
')?>

<?php endif ?>

<?php $this->registerJs('

    $("#text").hide();
    function initialize()
    {
        directionsRenderer = new google.maps.DirectionsRenderer();
        myCenter = new google.maps.LatLng(eventLat, eventLng);
        destination = myCenter;

        var mapProp = {
          center:myCenter,
          zoom:13,
          mapTypeId:google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("viewMap"),mapProp);

        directionsRenderer.setMap(map);

        var marker = new google.maps.Marker({
            map: map
        });

        marker.setPosition(myCenter);

        var infoWindowEvent = new google.maps.InfoWindow({
            content: "'. $model->evtMaps[0]->vc_EventTag . '"
        });
        infoWindowEvent.open(map, marker);
        google.maps.event.addListener(marker, "click", function(){
            infoWindowEvent.open(map, marker);
        });

        var markerT = new google.maps.Marker({
            map: map,
        });

        if (!transportLat == "") {
            transportLocation = new google.maps.LatLng(transportLat, transportLng);
            markerT.setPosition(transportLocation);
            origin = transportLocation;

            var infoWindowT = new google.maps.InfoWindow({
                content: "'. $model->evtMaps[0]->vc_TransportTag . '"
            });

            google.maps.event.addListener(markerT, "click", function(){
                infoWindowT.open(map, markerT);
            });
        } 

    }

    var showingRoute = false;
    $("#route").on("click", function () {
    
        var request = {
            origin: origin,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING  // Modos de viaje: DRIVING, WALKING, BYCICLING, TRANSIT 
        };
        if (!showingRoute){
            serviceRoutes.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(response);
                    directionsRenderer.setMap(map);
                    showingRoute = true;
                }
            });
        } else {
            showingRoute = false;
            directionsRenderer.setMap(null);
        }
    })

    $("#currentLocation").on("click", function () {
        if (geoPosition.init()) {
            geoPosition.getCurrentPosition(success, errorHandler, {timeout:5000});
        } else {
            error("Perdón, no hemos podido encontrar tu ubicación");
        }  
    })
 
    function success(position) {
        $("#text").show();
      var s = document.querySelector("#status");
      if (s.className == "success") {    
        return;
      }
       
      s.innerHTML = "Estás aquí:";
      s.className = "success";
          
      var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
      origin = latlng;

      var markerUser = new google.maps.Marker({
          position: latlng, 
          map: map, 
      });

        var infoWindowUser = new google.maps.InfoWindow({
                content: "Aquí estas tú"
            });
         infoWindowUser.open(map, markerUser);

            google.maps.event.addListener(markerUser, "click", function(){
                infoWindowT.open(map, markerUser);
            });

        map.setCenter(latlng);
        map.setZoom(12);

    }
 
function errorHandler(err) {
  var s = document.querySelector("#status");
  s.innerHTML = typeof msg == "string" ? msg : "failed";
  s.className = "fail";  
}

    google.maps.event.addDomListener(window, "load", initialize);

'); ?>

<?php endif ?>

<?php
$this->title = $model->i_Pk_Event;
$this->params['breadcrumbs'][] = ['label' => 'Cat Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div>
    <p>

<?php
    if(!empty($model->evtImages)){
        echo yii\bootstrap\Carousel::widget(['items'=>$images]);
    }
    
?>
</p>
</div>

<div>
<?php $this->registerJs("
    $('.field-itinerary-i_fktbl_user').hide();
    $('.field-itinerary-i_fktbl_event').hide();
    
    $('#itinerary-i_fktbl_event').val('".$model->i_Pk_Event."');
    "); 
?>


<?php if (!empty ($model->evtMaps)): ?>

<div class="col-md-6">
    
<?php endif ?>
    
<div class="cat-event-view">

    
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->i_Pk_Event], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->i_Pk_Event], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],

        ]) ?>

        <?php if (empty ($model->evtMaps)): ?>
            <?= Html::a(Yii::t('app', 'Create Evt Map'), ['evt-map/create', 'id' => $model->i_Pk_Event], ['class' => 'btn btn-success']) ?>
        <?php endif ?>
    

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'i_Pk_Event',
            'i_FkTbl_User',
            'vc_EventName',
            'tx_DescriptionEvent:ntext',
            'vc_EventAddress',
            'vc_EventCity',
            'dt_EventStart',
            'dt_EventEnd',
            'dc_EventCost',
            'dc_TransportCost', 
        ],
    ]) ?>
    
    <?= $this->render('..\itinerary\_form', [
        'model' => new Itinerary(),
        'userID' =>$userID    
    ]) ?>
    <?= $this->render('..\evt-comment\_form', [
        'model' => new EvtComment(),
        'userID' => $userID, //Le paso al formulario el id del usuario logueado
        'eventID'=>$model->i_Pk_Event//'eventID'=>$eventID
    ])?>
</div>
</div>

<?php if (!empty ($model->evtMaps)): ?>
<div class="col-md-6">
<p>
        <?= Html::a(Yii::t('app', 'Update Map'), ['evt-map/update', 'id' =>$model->evtMaps[0]->i_Pk_Map], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete Map'), ['evt-map/delete', 'id' =>$model->evtMaps[0]->i_Pk_Map], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Seguro que deseas eliminar el mapa?'),
                'method' => 'post',
            ],
        ]) ?>       
        <?= Html::button(Yii::t('app', 'Route'), ['class' => 'btn btn-primary', 'id'=>"route"]) ?>
        <?= Html::button(Yii::t('app', 'Current location'), ['class' => 'btn btn-primary', 'id'=>"currentLocation"]) ?>
        <div id = "text"><p>Buscando...<span id="status"></span></p></div>
    <?php endif ?>


    <?php if (!empty ($model->evtMaps)): ?>
</p>
<div id="viewMap" style="width:500px;height:380px;">     

</div>

</div>

<?php endif ?>
</div>
<?php




