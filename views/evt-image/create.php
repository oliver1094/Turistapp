<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EvtImage */

$this->title = Yii::t('app', 'Create Evt Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Evt Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
