<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\CatEvent;
use app\models\CatUser;


/* @var $this yii\web\View */
/* @var $searchModel app\models\CatEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Lista de eventos';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="cat-event-index animated fadeInDown">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Crear un Evento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="ibox-content">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-striped'],        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'vc_EventName',
                'value'=> 'vc_EventName',
                'filter'=> Html::activeDropDownList(
                    $searchModel,
                    'vc_EventName',
                    ArrayHelper::map(
                        CatEvent::find()->asArray()->all(),
                        'vc_EventName',
                        'vc_EventName'
                    ),
                    ['class'=>'form-control','prompt'=>'--All--']
                ),
            ],
            'tx_DescriptionEvent:ntext',
            [
                'attribute' => 'vc_NameUser',             
                'label' => 'Nombre del creador',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a(Html::encode(
                        $data['iFkTblUser']['vc_FirstName']
                    ),
                    Url::to(['catuser/view','id'=> $data['i_FkTbl_User']]));
                },
            ],
            [
                'attribute'=>'dt_EventStart',
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
                'attribute'=>'dt_EventEnd',
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
                'attribute'=>'dc_EventCost',
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
                'attribute'=>'vc_EventCity',
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div>
