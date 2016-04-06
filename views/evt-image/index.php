<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EvtImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Eliminar imágenes ');
$this->params['breadcrumbs'][] = ['label' => 'Lista de eventos', 'url' => ['/cat-event/index']];
$this->params['breadcrumbs'][] = ['label' => 'Mis eventos', 'url' => ['/cat-event/my-events']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Eliminar imágenes');
?>
<div class="evt-image-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Eliminar todas'), ['delete-all', 'id' => $eventID], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
    ])?>

</div>
