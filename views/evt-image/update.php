<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EvtImage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Evt Image',
]) . ' ' . $model->i_Pk_Image;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Evt Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->i_Pk_Image, 'url' => ['view', 'id' => $model->i_Pk_Image]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="evt-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
