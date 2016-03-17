<div class="col-md-6" >  
<?= \imanilchaudhari\socialshare\ShareButton::widget([
        'style'=>'horizontal',
        'networks' => ['facebook','googleplus','linkedin','twitter'],
        'data_via'=>'imanilchaudhari', //twitter username (for twitter only, if exists else leave empty)
]); ?>
</div>
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
    
</div>
</div>

<?php if (!empty ($model->evtMaps)): ?>
<div class="col-md-6">
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

<?php endif ?>
<div >    
<?php
if ($idUserComment!=null) {
    foreach ($idUserComment as $value) { 
    }
    if ( $value!=$userID) {?>
     <?= $this->render('..\evt-comment\_form', [
        'model' => new EvtComment(),
        'userID' => $userID, 
        'eventID'=>$model->i_Pk_Event
    ])?>  
<?php 
      }?>
      <table  cellspacing="60" cellpadding="10" border="3">
        <tr>
    <th><h4>Nombre</h4></th >
    <th><h4>Apellido</h4></th >     
    <th><h4>Comentario</h4></th>        
    <th><h4>Calificacion</h4></th>
        </tr>
         <tr>
    <th><?php echo $table =implode(' <br/>', $firstName) ?></th>
    <th><?php echo $table =implode(' <br/>', $lastName) ?></th>
    <th><?php echo $table =implode(' <br/>', $commentsAll) ?></th>
    <th><?php echo $table =implode(' <br/>', $score) ?></th     >    
            </tr>
      </table>
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
        'userID' => $userID, 
        'eventID'=>$model->i_Pk_Event
    ])?>         
<?php 
      } ?>
      
</div>

</div>
<?php




