<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */

$this->title = 'Crear evento';
$this->params['breadcrumbs'][] = ['label' => 'Cat Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= $this->render('_form', [
        'model' => $model,
        'evtmap' => $evtmap,
    ]) ?>

</div>
