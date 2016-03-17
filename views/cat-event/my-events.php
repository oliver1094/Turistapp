<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\CatEvent;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crrear evento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'vc_EventName',
            'vc_EventAddress',
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
