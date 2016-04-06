<?php

use yii\helpers\Html;
use app\models\CatEvent;
use app\models\CatEventSearch;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Itinerary */



$this->title = 'Add event to itinerary';
$this->params['breadcrumbs'][] = ['label' => 'Itineraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itinerary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userID' => $userID
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'i_Pk_Event',
            [
                'attribute'=>'Name',
                'value'=> 'vc_EventName',
                'filter'=> Html::activeDropDownList($searchModel, 
                    'vc_EventName', 
                    ArrayHelper::map(
                        CatEvent::find()->asArray()->all(),
                        'vc_EventName',
                        'vc_EventName'
                    ),
                    ['class'=>'form-control','prompt'=>'--All--']
                ),
            ],
            [
                'attribute'=>'Description',
                'value'=> 'tx_DescriptionEvent',
            ],
            'vc_EventAddress',
            [
                'attribute'=>'Start',
                'value'=> 'dt_EventStart',
                'filter'=> Html::activeDropDownList(
                    $searchModel, 
                    'dt_EventStart', 
                    ArrayHelper::map(
                        CatEvent::find()->asArray()->all(),
                        'dt_EventStart',
                        'dt_EventStart'
                    ),
                    ['class'=>'form-control','prompt'=>'--All--']
                ),
            ],
            [
                'attribute'=>'End',
                'value'=> 'dt_EventEnd',
                'filter'=> Html::activeDropDownList(
                    $searchModel, 
                    'dt_EventEnd', 
                    ArrayHelper::map(
                        CatEvent::find()->asArray()->all(),
                        'dt_EventEnd',
                        'dt_EventEnd'
                    ),
                    ['class'=>'form-control','prompt'=>'--All--']
                ),
            ],
            [
                'attribute'=>'Cost',
                'value'=> 'dc_EventCost',
                'filter'=> Html::activeDropDownList(
                    $searchModel,
                    'dc_EventCost', 
                    ArrayHelper::map(
                        CatEvent::find()->asArray()->all(),
                        'dc_EventCost',
                        'dc_EventCost'
                    ),
                    ['class'=>'form-control','prompt'=>'--All--']
                ),
            ],
            [
                'attribute'=>'City',
                'value'=> 'vc_EventCity',
                'filter'=> Html::activeDropDownList(
                    $searchModel, 
                    'vc_EventCity', 
                    ArrayHelper::map(
                        CatEvent::find()->asArray()->all(),
                        'vc_EventCity',
                        'vc_EventCity'
                    ),
                    ['class'=>'form-control','prompt'=>'--All--']
                ),
            ],
            [
                'attribute'=>'Transport Cost',
                'value'=> 'dc_TransportCost',
                'filter'=> Html::activeDropDownList(
                    $searchModel, 
                    'dc_TransportCost', 
                    ArrayHelper::map(
                        CatEvent::find()->asArray()->all(),
                        'dc_TransportCost',
                        'dc_TransportCost'
                    ),
                    ['class'=>'form-control','prompt'=>'--All--']
                ),
            ]
        ],
    ]); ?>
</div>
