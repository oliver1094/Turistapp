<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EvtImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Evt Images');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
        <?= Html::a(Yii::t('app', 'Eliminar todas'), ['delete-all', 'id' => $eventID], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'image',
                'label' => 'Imágen',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::img(Yii::getAlias('@web').'/files/'. $data['vc_DirectoryName'],
                    ['width' => '260px']);
                },
            ],

            ['class' => yii\grid\ActionColumn::className(),'template'=>'{delete}'],
        ],
    ]); ?>


</div>
