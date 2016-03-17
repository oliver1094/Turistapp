<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */

$this->title = 'Actualizar evento: ' . ' ' . $model->vc_EventName;
$this->params['breadcrumbs'][] = ['label' => 'Lista de eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vc_EventName, 'url' => ['view', 'id' => $model->i_Pk_Event]];
$this->params['breadcrumbs'][] = 'Actualizar evento';
?>
<div class="cat-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'evtmap' => $evtmap,
    ]) ?>

</div>
