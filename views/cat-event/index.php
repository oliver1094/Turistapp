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
            
            [
                'attribute' => 'vc_NameUser',
                //'value' => 'iFkTblUser.vc_FirstName',                
                'label' => 'Nombre del creador',
                'format' => 'raw',
     'value'=>function ($data) {
        //return Html::a(Html::encode($data['iFkTblUser']['vc_FirstName']),'../catuser/view?id='.$data['i_FkTbl_User']);
        return Html::a(Html::encode($data['iFkTblUser']['vc_FirstName']), Url::to(['catuser/view','id'=> $data['i_FkTbl_User']]));
        

    },



            ],
            

            [
                'attribute'=>'Name',
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
            'tx_DescriptionEvent:ntext',
            'vc_EventAddress',
            //'dt_EventStart',
            [
                'attribute'=>'Start',
                'value'=> 'dt_EventStart',
                'filter'=> Html::activeDropDownList($searchModel, 
                                                    'dt_EventStart', 
                                                    ArrayHelper::map(CatEvent::find()->asArray()->all(),
                                                                    'dt_EventStart',
                                                                    'dt_EventStart'
                                                                    ),
                                                                ['class'=>'form-control','prompt'=>'--All--']
                                                    ),
            ],
            
            //'dt_EventEnd',
            [
                'attribute'=>'End',
                'value'=> 'dt_EventEnd',
                'filter'=> Html::activeDropDownList($searchModel, 
                                                    'dt_EventEnd', 
                                                    ArrayHelper::map(CatEvent::find()->asArray()->all(),
                                                                    'dt_EventEnd',
                                                                    'dt_EventEnd'
                                                                    ),
                                                                ['class'=>'form-control','prompt'=>'--All--']
                                                    ),
            ],
            //'dc_EventCost',
            [
                'attribute'=>'Cost',
                'value'=> 'dc_EventCost',
                'filter'=> Html::activeDropDownList($searchModel, 
                                                    'dc_EventCost', 
                                                    ArrayHelper::map(CatEvent::find()->asArray()->all(),
                                                                    'dc_EventCost',
                                                                    'dc_EventCost'
                                                                    ),
                                                                ['class'=>'form-control','prompt'=>'--All--']
                                                    ),
            ],
            [
                'attribute'=>'City',
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
