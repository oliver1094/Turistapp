<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EvtMap */

$this->title = 'Update Evt Map: ' . ' ' . $model->i_Pk_Map;
$this->params['breadcrumbs'][] = ['label' => 'Evt Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->i_Pk_Map, 'url' => ['view', 'id' => $model->i_Pk_Map]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evt-map-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
