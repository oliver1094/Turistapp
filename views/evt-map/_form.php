<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\EvtMap */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $this->registerJsFile('http://maps.googleapis.com/maps/api/js?sensor=false', ['depends' => [\yii\web\JqueryAsset::className()]]);
     $this->registerJsFile('http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php $this->registerJs('
    $("#textE").hide();
    $("#textT").hide();

    var map;
    var transportMap;
    var myCenter;
    var transportLocation;

    var eventLat = document.getElementById("evtmap-vc_latitude").value;
    var eventLng = document.getElementById("evtmap-vc_longitude").value;

    var transportLat = document.getElementById("evtmap-vc_latitudetransport").value;
    var transportLng = document.getElementById("evtmap-vc_longitudetransport").value;

    function initialize()
    {

        if (eventLat == "") {
            myCenter = new google.maps.LatLng(20.9663671,-89.6067274);
        } else {
            myCenter = new google.maps.LatLng(eventLat, eventLng);
        }
 
        var mapProp = {
          center:myCenter,
          zoom:13,
          mapTypeId:google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("eventMap"),mapProp);

        var input = (document.getElementById("evtmap-searchbox"));
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo("bounds", map);

        var marker = new google.maps.Marker({
            map: map,
            draggable: true
        });

        var markerPlaces = new google.maps.Marker({
            map: map,
        });

        if (!eventLat == "") {
            marker.setPosition(myCenter);
        }
        
        google.maps.event.addListener(autocomplete, "place_changed", function() {
            var place = autocomplete.getPlace();
            marker.setVisible(false);
            if (!place.geometry) {
              return;
            }

            if (place.geometry.viewport) {
              map.fitBounds(place.geometry.viewport);
            } else {
              map.setCenter(place.geometry.location);
              map.setZoom(17);
            }

            // Set the position of the marker using the place ID and location.
            markerPlaces.setPlace(/** @type {!google.maps.Place} */ ({
                placeId: place.place_id,
                location: place.geometry.location
            }));
            markerPlaces.setVisible(true);
            $("#evtmap-vc_latitude").val(place.geometry.location.lat());
            $("#evtmap-vc_longitude").val(place.geometry.location.lng());
        });   

        google.maps.event.addListener(map, "click", function(event) {
            markerPlaces.setVisible(false);
            var newlocation = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
            $("#evtmap-vc_latitude").val(event.latLng.lat());
            $("#evtmap-vc_longitude").val(event.latLng.lng());
            marker.setPosition(newlocation);
            marker.setVisible(true);
        });

        google.maps.event.addListener(marker, "dragend", function(evt) {
            $("#evtmap-vc_latitude").val(evt.latLng.lat());
            $("#evtmap-vc_longitude").val(evt.latLng.lng());
        });
    }

    $("#currentLocationE").on("click", function () {
        if (geoPosition.init()) {
            geoPosition.getCurrentPosition(successE, errorHandler, {timeout:5000});
        } else {
            error("Perdón, no hemos podido encontrar tu ubicación");
        }  
    })
 
    function successE(position) {
        $("#evtmap-vc_latitude").val(null);
        $("#evtmap-vc_longitude").val(null);
        initialize();
      var s = document.querySelector("#statusE");
      if (s.className == "success") {    
        return;
      }
       
      s.className = "success";
          
      var latlngE = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        $("#evtmap-vc_latitude").val(position.coords.latitude);
        $("#evtmap-vc_longitude").val(position.coords.longitude);
        var markerUser = new google.maps.Marker({
          position: latlngE, 
          map: map, 
        });
        
        map.setCenter(latlngE);
        map.setZoom(12);

    }
 
    function errorHandler(err) {
      var s = document.querySelector("#statusE");
      s.innerHTML = typeof msg == "string" ? msg : "failed";
      s.className = "fail";  
    }

    function initializeTranportMap()
    {
        var transportLat = document.getElementById("evtmap-vc_latitudetransport").value;
        if (transportLat == "" || transportLat == null) {
            transportLocation = new google.maps.LatLng(20.9663671,-89.6067274);
        } else {
            transportLocation = new google.maps.LatLng(transportLat, transportLng);
        }

        var mapProp = {
          center:transportLocation,
          zoom:13,
          mapTypeId:google.maps.MapTypeId.ROADMAP
        };

        transportMap = new google.maps.Map(document.getElementById("transportMap"),mapProp);

        var inputT = (document.getElementById("evtmap-searchboxtransport"));
        var autocompleteT = new google.maps.places.Autocomplete(inputT);
        autocompleteT.bindTo("bounds", transportMap);

        var markerT = new google.maps.Marker({
            map: transportMap,
            draggable: true
        });

        var markerPlacesT = new google.maps.Marker({
            map: transportMap,
        });

        if (!transportLat == "") {
            markerT.setPosition(transportLocation);
        }
        
        google.maps.event.addListener(autocompleteT, "place_changed", function() {
            var place = autocompleteT.getPlace();
            markerT.setVisible(false);
            if (!place.geometry) {
              return;
            }

            if (place.geometry.viewport) {
              transportMap.fitBounds(place.geometry.viewport);
            } else {
              transportMap.setCenter(place.geometry.location);
              transportMap.setZoom(17);
            }

            // Set the position of the marker using the place ID and location.
            markerPlacesT.setPlace(/** @type {!google.maps.Place} */ ({
                placeId: place.place_id,
                location: place.geometry.location
            }));
            markerPlacesT.setVisible(true);
            $("#evtmap-vc_latitudetransport").val(place.geometry.location.lat());
            $("#evtmap-vc_longitudetransport").val(place.geometry.location.lng());
        });   

        google.maps.event.addListener(transportMap, "click", function(event) {
            markerPlacesT.setVisible(false);
            var newlocation = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
            $("#evtmap-vc_latitudetransport").val(event.latLng.lat());
            $("#evtmap-vc_longitudetransport").val(event.latLng.lng());
            markerT.setPosition(newlocation);
            markerT.setVisible(true);
        });

        google.maps.event.addListener(markerT, "dragend", function(evt) {
            $("#evtmap-vc_latitudetransport").val(evt.latLng.lat());
            $("#evtmap-vc_longitudetransport").val(evt.latLng.lng());
        });
    }

    $("#currentLocationT").on("click", function () {
        if (geoPosition.init()) {
            geoPosition.getCurrentPosition(successT, errorHandler, {timeout:5000});
        } else {
            error("Perdón, no hemos podido encontrar tu ubicación");
        }  
    })
 
    function successT(position) {
        $("#evtmap-vc_latitudetransport").val(null);
        $("#evtmap-vc_longitudetransport").val(null);
        initializeTranportMap();
      var s = document.querySelector("#statusT");
      if (s.className == "success") {    
        return;
      }
       
      s.className = "success";
          
      var latlngT = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        $("#evtmap-vc_latitudetransport").val(position.coords.latitude);
        $("#evtmap-vc_longitudetransport").val(position.coords.longitude);
        var markerUser = new google.maps.Marker({
          position: latlngT, 
          map: transportMap, 
        });
        
        transportMap.setCenter(latlngT);
        transportMap.setZoom(12);

    }
 
    function errorHandler(err) {
      var s = document.querySelector("#statusE");
      s.innerHTML = typeof msg == "string" ? msg : "failed";
      s.className = "fail";  
    }

    google.maps.event.addDomListener(window, "load", initialize);

    $("#transMapForm").hide();
    $("#transportMapDiv").hide();

    $("#buttonEvent").on("click", function () {
        $("#evtMapForm").show();
        $("#transMapForm").hide();
        $("#eventMapDiv").show();
        $("#transportMapDiv").hide();
    })

    $("#buttonTrans").on("click", function () {
        $("#evtMapForm").hide();
        $("#transMapForm").show();
        $("#transportMapDiv").show();
        $("#eventMapDiv").hide();
        initializeTranportMap();
    })

    $("#clearTransport").on("click", function () {
        $("#evtmap-vc_latitudetransport").val(null);
        $("#evtmap-vc_longitudetransport").val(null);
        $("#evtmap-vc_transporttag").val(null);
        initializeTranportMap();
    })

'); ?>
<div class="col-md-6">
<div class="evt-map-form">
    <?= Html::button(Yii::t('app', 'Mapa de evento'), ['class' => 'btn btn-primary', 'id'=>"buttonEvent"]) ?>
    <?= Html::button(Yii::t('app', 'Mapa de transporte'), ['class' => 'btn btn-primary', 'id'=>"buttonTrans"]) ?>

    
    
    

    <?php $form = ActiveForm::begin(); ?>
<div id="evtMapForm">
    <?= $form->field($model, 'searchbox')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'vc_EventTag')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'i_FkTbl_Event'); ?>

    <?= Html::activeHiddenInput($model, 'vc_Latitude'); ?>

    <?= Html::activeHiddenInput($model, 'vc_Longitude'); ?>

</div>
<div id="transMapForm">
    <?= $form->field($model, 'searchboxTransport')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'vc_TransportTag')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'vc_LatitudeTransport'); ?>

    <?= Html::activeHiddenInput($model, 'vc_LongitudeTransport'); ?>

</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>

</div>
</div>
<div id = "eventMapDiv" class="col-md-6">
    <p>
    <?= Html::button(Yii::t('app', 'Mi ubicación actual'), ['class' => 'btn btn-primary', 'id'=>"currentLocationE"]) ?>
    </p>
    <div id = "textE"><p>Buscando...<span id="statusE"></span></p></div>
    <div id="eventMap"  style="width:500px;height:380px;">
    </div>
</div>

<div id = "transportMapDiv" class="col-md-6">
    <p>
    <?= Html::button(Yii::t('app', 'Mi ubicación actual'), ['class' => 'btn btn-primary', 'id'=>"currentLocationT"]) ?>
    <?= Html::button(Yii::t('app', 'Eliminar marcador'), ['class' => 'btn btn-danger', 'id'=>"clearTransport"]) ?>
    </p>
    <div id = "textT"><p>Buscando...<span id="statusT"></span></p></div>
    <div id="transportMap" style="width:500px;height:380px;">
    </div>
</div>
