<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EvtMapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evt-map-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'i_Pk_Map') ?>

    <?= $form->field($model, 'i_FkTbl_Event') ?>

    <?= $form->field($model, 'vc_Latitude') ?>

    <?= $form->field($model, 'vc_Longitude') ?>

    <?= $form->field($model, 'vc_EventTag') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
