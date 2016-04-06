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


<?php /* Message that the event was added to the itinerary */ 
if (Yii::$app->session->hasFlash('eventAdded')): ?>
    <div class="alert alert-success">
        Se ha agregado el evento al irinerario.
    </div>
<?php /* Message that the event is already in the itinerary */ 
elseif (Yii::$app->session->hasFlash('eventNotAdded')): ?>
    <div class="alert alert-danger">
        Ya se tiene este evento en el itinerario.
    </div>
<?php endif ?>

<?php
$this->title = $model->vc_EventName;
$this->params['breadcrumbs'][] = ['label' => 'Lista de eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="ibox-content animated fadeInDown" style="display: block;">  
<p>

<?php /* Validates if there is images */ 
if(!empty($model->evtImages)){
        echo yii\bootstrap\Carousel::widget(['items'=>$images]);
}?>

</p>
</div>

<div>
    <?php /* Validates if there is a map */ 
    if (!empty ($model->evtMaps)): ?>
    <div class="row">
    <div class="col-md-6 ">
    <?php endif ?>
    <br>
    <div class="cat-event-view">
    <div class="ibox-content animated fadeInDown" style="display: block;">
    <?php /* The user is allowed to change this event */ 
    if (CatEventController:: allowed($model->i_Pk_Event)) : ?>
        <p>
        <?= Html::a('Actualizar evento', 
            ['update', 'id' => $model->i_Pk_Event], ['class' => 'btn btn-primary']) 
        ?>
        <?= Html::a('Eliminar evento',
            ['delete', 'id' => $model->i_Pk_Event], 
            [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Seguro que deseas eliminar el evento?',
                    'method' => 'post',
                ],
            ]
        )?>

        <?php /* Validates if there is images */ 
        if (!empty ($model->evtImages)): ?>
            <?= Html::a(Yii::t('app', 'Eliminar imágenes'),
                ['evt-image/index', 'id' => $model->i_Pk_Event],
                ['class' => 'btn btn-danger']) 
            ?>
        <?php endif ?>

        <?php /* Validates if there is a map */ 
        if (empty ($model->evtMaps)): ?>
            <?= Html::a(Yii::t('app', 'Crear mapa'), 
                ['evt-map/create', 'id' => $model->i_Pk_Event], 
                ['class' => 'btn btn-success']) 
            ?>
        <?php endif ?>

        </p>
    <?php endif ?>

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
        'networks' => ['facebook','twitter'],
        'data_via'=>'imanilchaudhari', 
    ]) ?>

    <br>
    <?= Html::a(Yii::t('app', 'Agregar a itinerario'), 
        ['itinerary/create', 'id' =>$model->i_Pk_Event], 
        ['class' => 'btn btn-primary']) 
    ?>
    
    </div>
    </div>
    </div>

    <?= $this->render('maps', ['model' => $model])?> 

    <br>

    <?= $this->render('comments', [
        'model' => $model,
        'commentsAll'=>$commentsAll,
        'score'=>$score,
        'firstName'=>$firstName,
        'idUserComment'=>$idUserComment,
        'media'=>$media
    ])?> 

</div>
<?php




