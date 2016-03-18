<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */

$this->title = 'Crear evento';
$this->params['breadcrumbs'][] = ['label' => 'Cat Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-event-create animated fadeInDown">

<div class="row">
<div class="col-lg-12">
<div class="ibox float-e-margins">
	<div class="ibox-title">
	<h3>Registro de Evento</h3>
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
