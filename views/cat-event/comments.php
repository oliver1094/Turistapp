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

<div class="ibox-content animated fadeInDown" style="display: block;">  
<?php if ($idUserComment!=null) {?>

  <h2>Calificación del evento</h2>

  <?php echo StarRating::widget(['disabled'=>true,'name' => 'rating_19','value'=>$media, 
    'pluginOptions' => [
      'stars' => 5, 
      'max' => 5,
      'step' => 1.0,
    ]
  ]);

  foreach ($idUserComment as $value){}
  if ( $value!=Yii::$app->user->getId()) {?>

    <?= $this->render('..\evt-comment\_form', [
      'model' => new EvtComment(),
      'userID' => Yii::$app->user->getId(), 
      'eventID'=>$model->i_Pk_Event
    ])?>  
  <?php }?>

  <h2>Comentarios</h2>
  <div class="ibox-content">
    <table class="table">
    <thead>
      <tr>
      <th><h4>Nombre</h4></th >   
      <th><h4>Comentario</h4></th>        
      <th><h4>Calificacion</h4></th>
      </tr>
    </thead>

    <tbody>
      <tr>
      <td><?php echo $table =implode(' <br/><br/>', $firstName) ?></td>
      <td><?php echo $table =implode(' <br/><br/>', $commentsAll) ?></td>
      <td><?php echo $table =implode(' <br/><br/>', $score) ?></td>    
      </tr>
    </tbody>
    </table>
  </div>
      
<?php } else {?>

  <?= $this->render('..\evt-comment\_form', [
    'model' => new EvtComment(),
    'userID' => Yii::$app->user->getId(), 
    'eventID'=>$model->i_Pk_Event
  ])?>         
<?php } 
?>
</div>