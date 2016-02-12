<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\CatEvent;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cat Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cat Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'i_Pk_Event',
            'i_FkTbl_User',
            [
                'attribute'=>'Event name',
                'value'=> 'vc_EventName',
                'filter'=> Html::activeDropDownList($searchModel, 
                                                    'vc_EventName', 
                                                    ArrayHelper::map(CatEvent::find()->asArray()->all(),
                                                                    'vc_EventName',
                                                                    'vc_EventName'
                                                                    ),
                                                                ['class'=>'form-control','prompt'=>'--All--']
                                                    ),
            ],
            'vc_EventAddress',
            [
                'attribute'=>'Event city',
                'value'=> 'vc_EventCity',
                'filter'=> Html::activeDropDownList($searchModel, 
                                                    'vc_EventCity', 
                                                    ArrayHelper::map(CatEvent::find()->asArray()->all(),
                                                                     'vc_EventCity',
                                                                     'vc_EventCity'
                                                                    ),
                                                                ['class'=>'form-control','prompt'=>'--All--']
                                                    ),
            ],
            // 'dt_EventStart',
            // 'dt_EventEnd',
            // 'dc_EventCost',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
 

</div>
