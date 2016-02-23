<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItinerarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My itinerary';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itinerary-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'i_FkTbl_Event',
            'iFkTblEvent.vc_EventName',
            
            ['class' => yii\grid\ActionColumn::className(),'template'=>'{view} {delete}']
            //['class' => 'yii\grid\ActionColumn'],
        ],
       ]); ?>
    
<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
      'events'=> $events,
  ));
    ?> 
</div>
