<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */

$this->title = 'Update Cat Event: ' . ' ' . $model->i_Pk_Event;
$this->params['breadcrumbs'][] = ['label' => 'Cat Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->i_Pk_Event, 'url' => ['view', 'id' => $model->i_Pk_Event]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cat-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'evtmap' => $evtmap,
    ]) ?>

</div>
