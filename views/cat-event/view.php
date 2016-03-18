<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Itinerary;
use app\models\EvtComment;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;   
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */
?>

<?php if (Yii::$app->session->hasFlash('eventAdded')): ?>
    <div class="alert alert-success">
        Se ha agregado el evento al irinerario.
    </div>
<?php elseif (Yii::$app->session->hasFlash('eventNotAdded')): ?>
    <div class="alert alert-danger">
        Ya se tiene este evento en el itinerario.
    </div>
<?php endif ?>


<?php if (!empty ($model->evtMaps)): ?>
<?php
    $eventVariables = '
        var eventLat = '. $model->evtMaps[0]->vc_Latitude .';
        var eventLng = '. $model->evtMaps[0]->vc_Longitude .';
        var eventTag = "'. $model->evtMaps[0]->vc_EventTag .'";
    ';
$this->registerJs($eventVariables, View::POS_HEAD, 'eventVariables');
?>
<?php if (!empty($model->evtMaps[0]->vc_LatitudeTransport)) : ?>
<?php 
$transportVariables ='
    transportLat = ' . $model->evtMaps[0]->vc_LatitudeTransport . ';
    transportLng = '. $model->evtMaps[0]->vc_LongitudeTransport .';
    var transportTag = "'. $model->evtMaps[0]->vc_TransportTag .'";
';
$this->registerJs($transportVariables, View::POS_HEAD, 'transportVariables');
?>
<?php else : ?>
<?php
$transportNull ='    
    transportLat = "";
    transportLng = "";
';
$this->registerJs($transportNull, View::POS_HEAD, 'transportNull');
?>
<?php endif ?>
<?php endif ?>

<?php
$this->title = $model->vc_EventName;
$this->params['breadcrumbs'][] = ['label' => 'Lista de eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="ibox-content animated fadeInDown" style="display: block;">
    <p>

<?php
    if(!empty($model->evtImages)){

        echo yii\bootstrap\Carousel::widget(['items'=>$images]);
    }
    
?>
</p>
</div>

<div>

<?php if (!empty ($model->evtMaps)): ?>
<div class="row">
<div class="col-md-6 ">
    
<?php endif ?>
    <br>
<div class="cat-event-view">
    <div class="ibox-content animated fadeInDown" style="display: block;">
    <?php if ($model->i_FkTbl_User == Yii::$app->user->getId() || Yii::$app->user->can('admin')): ?>
    <p>
        <?= Html::a('Actualizar evento', ['update', 'id' => $model->i_Pk_Event], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar evento', ['delete', 'id' => $model->i_Pk_Event], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro que deseas eliminar el evento?',
                'method' => 'post',
            ],

        ]) ?>

        <?php if (!empty ($model->evtImages)): ?>
            <?= Html::a(Yii::t('app', 'Eliminar imágenes'), ['evt-image/index', 'id' => $model->i_Pk_Event], ['class' => 'btn btn-danger']) ?>
        <?php endif ?>

        <?php if (empty ($model->evtMaps)): ?>
            <?= Html::a(Yii::t('app', 'Crear mapa'), ['evt-map/create', 'id' => $model->i_Pk_Event], ['class' => 'btn btn-success']) ?>
        <?php endif ?>
    <?php endif ?>
    

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label'=>'Organizador',
                'value'=> $model->iFkTblUser->vc_FirstName . ' ' . $model->iFkTblUser->vc_LastName,
            ],
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

    <?= \imanilchaudhari\socialshare\ShareButton::widget([
        'style'=>'horizontal',
        'networks' => ['facebook','googleplus','linkedin','twitter'],
        'data_via'=>'imanilchaudhari', //twitter username (for twitter only, if exists else leave empty)
]); ?>

<br>
<?= Html::a(Yii::t('app', 'Agregar a itinerario'), ['itinerary/create', 'id' =>$model->i_Pk_Event], ['class' => 'btn btn-primary']) ?>
    
    
    </div>
    
</div>







</div>


<?php if (!empty ($model->evtMaps)): ?>
    
    
<div class="col-md-6">
<br>
<div class="ibox-content animated fadeInDown" style="display: block;">

<p>
    <?php if ($model->i_FkTbl_User == Yii::$app->user->getId() || Yii::$app->user->can('admin')): ?>
        <?= Html::a(Yii::t('app', 'Modificar mapa'), ['evt-map/update', 'id' =>$model->evtMaps[0]->i_Pk_Map], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar mapa'), ['evt-map/delete', 'id' =>$model->evtMaps[0]->i_Pk_Map], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Seguro que deseas eliminar el mapa?'),
                'method' => 'post',
            ],
        ]) ?> 
    <?php endif ?>      
        <?= Html::button(Yii::t('app', 'Ruta'), ['class' => 'btn btn-primary', 'id'=>"route"]) ?>
        <?= Html::button(Yii::t('app', 'Ubicación actual'), ['class' => 'btn btn-primary', 'id'=>"currentLocation"]) ?>
        <div id = "text"><p>Buscando...<span id="status"></span></p></div>
    <?php endif ?>


    <?php if (!empty ($model->evtMaps)): ?>
</p>
<div id="viewMap" style="width:500px;height:380px;">     

</div>
</div>
</div>

</div>

<?php endif ?>
<br>
<div class="ibox-content animated fadeInDown" style="display: block;">  
<?php
if ($idUserComment!=null) {
    foreach ($idUserComment as $value) { 
    }
    if ( $value!=Yii::$app->user->getId()) {?>
     <?= $this->render('..\evt-comment\_form', [
        'model' => new EvtComment(),
        'userID' => Yii::$app->user->getId(), 
        'eventID'=>$model->i_Pk_Event
    ])?>  
<?php 
      }?>
      <div class="ibox-content">
      <table class="table">
      <thead>
        <tr>
    <th><h4>Nombre</h4></th >
    <th><h4>Apellido</h4></th >     
    <th><h4>Comentario</h4></th>        
    <th><h4>Calificacion</h4></th>
        </tr>
        </thead>
        <tbody>
            
        
         <tr>
    <td><?php echo $table =implode(' <br/><br/>', $firstName) ?></td>
    <td><?php echo $table =implode(' <br/><br/>', $lastName) ?></td>
    <td><?php echo $table =implode(' <br/><br/>', $commentsAll) ?></td>
    <td><?php echo $table =implode(' <br/><br/>', $score) ?></td>    
            </tr>
            </tbody>
      </table>
      </div>

      <h2>Promedio de las calificaciones</h2>
<?php
        echo StarRating::widget(['disabled'=>true,'name' => 'rating_19','value'=>$media, 
        'pluginOptions' => [
        'stars' => 5, 
        'max' => 5,
        'step' => 1.0,]
        ]);
    } else {?>
     <?= $this->render('..\evt-comment\_form', [
        'model' => new EvtComment(),
        'userID' => Yii::$app->user->getId(), 
        'eventID'=>$model->i_Pk_Event
    ])?>         
<?php 
      } ?>
      
</div>

</div>
<?php




