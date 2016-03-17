<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EvtMap */

$this->title = Yii::t('app', 'Crear mapa');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-map-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
