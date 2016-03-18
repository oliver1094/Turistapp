<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EvtImage */

$this->title = Yii::t('app', 'Eliminar imágenes del evento: ' . $model->iFkTblEvent->vc_EventName);
$this->params['breadcrumbs'][] = ['label' => 'Lista de eventos', 'url' => ['/cat-event/index']];
$this->params['breadcrumbs'][] = ['label' => 'Mis eventos', 'url' => ['/cat-event/my-events']];
$this->params['breadcrumbs'][] = ['label' => $model->iFkTblEvent->vc_EventName, 'url' => ['/cat-event/view', 'id' => $model->i_FkTbl_Event]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Eliminar imágenes');
?>
<div class="evt-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
