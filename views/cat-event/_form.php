<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $this->registerJsFile('http://maps.googleapis.com/maps/api/js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php $this->registerJs('
    $(".field-evtmap-vc_latitude").hide();
    $(".field-evtmap-vc_longitude").hide();

    var map;
    var myCenter=new google.maps.LatLng(20.9663671,-89.6067274);

    function initialize()
    {
    var mapProp = {
      center:myCenter,
      zoom:13,
      mapTypeId:google.maps.MapTypeId.ROADMAP
      };

      map = new google.maps.Map(document.getElementById("googleMa"),mapProp);

      google.maps.event.addListener(map, "click", function(event) {
        addMarker(event.latLng);
      });
    }

    var id;
    var markers = {};
    var addMarker = function (location) {
        marker = new google.maps.Marker({ 
            position: location,
            map: map,
            draggable: true
        });
        id = marker.__gm_id
        markers[id] = marker; 

        var infowindow = new google.maps.InfoWindow({
            content: "Latitude: " + location.lat() + "<br>Longitude: " + location.lng()
        });
        infowindow.open(map,marker);
        $("#evtmap-vc_latitude").val(location.lat());
        $("#evtmap-vc_longitude").val(location.lng());

        google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
    }

    var delMarker = function (id) {
        marker = markers[id]; 
        marker.setMap(null);
    }

    google.maps.event.addDomListener(window, "load", initialize);

'); ?>
<?php if ($model->isNewRecord): ?>
<div class="col-md-6">
<?php endif ?>
    <div class="cat-event-form">

    <?php if (Yii::$app->session->hasFlash('eventFormSubmitted')): ?>

        <div class="alert alert-success">
            El evento se ha creado/actualizado correctamente.
        </div>

        <?= Html::a('Volver a mis eventos', 'my-events', ['title' => 'Go']) ?>

        
            
            <?php else: ?>

        <?php $form = ActiveForm::begin(); ?>

        

        <?= $form->field($model, 'vc_EventName')->textInput(['maxlength' => true]) ?>   

        <?= $form->field($model, 'tx_DescriptionEvent')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'vc_EventAddress')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'vc_EventCity')->textInput(['maxlength' => true]) ?>
        

        <?= $form->field($model, 'dt_EventStart')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
        ]) ?>

        <?= $form->field($model, 'dt_EventEnd')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
        ]) ?>

   
        

        <?= $form->field($model, 'dc_EventCost')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'dc_TransportCost')->textInput(['maxlength' => true]) ?>

        <?= $form->field($evtmap, 'vc_Latitude')->textInput(['maxlength' => true]) ?>

        <?= $form->field($evtmap, 'vc_Longitude')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Registrar Evento' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php if ($model->isNewRecord): ?>
<div id="googleMap" class="col-md-6" style="width:500px;height:380px;">
</div>
<?php endif ?>
<?php endif ?>

