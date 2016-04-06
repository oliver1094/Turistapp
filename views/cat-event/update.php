<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */

$this->title = 'Actualizar evento: ' . ' ' . $model->vc_EventName;
$this->params['breadcrumbs'][] = ['label' => 'Lista de eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vc_EventName, 'url' => ['view', 'id' => $model->i_Pk_Event]];
$this->params['breadcrumbs'][] = 'Actualizar evento';
?>
<div class="cat-event-update animated fadeInDown">
<div class="row">
<div class="col-lg-12">
<div class="ibox float-e-margins">
    
	<div class="ibox-title">
	<h3><?= Html::encode($this->title) ?></h3>
	</div>

	<div class="ibox-content" style="display: block;">

    <?= $this->render('_form', [
        'model' => $model,
        'evtmap' => $evtmap,
    ]) ?>

    </div>

</div>
</div>
</div>
</div>
