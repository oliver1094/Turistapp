<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatEventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'i_Pk_Event') ?>

    <?= $form->field($model, 'i_FkTbl_User') ?>

    <?= $form->field($model, 'vc_EventName') ?>

    <?= $form->field($model, 'tx_DescriptionEvent') ?>

    <?= $form->field($model, 'vc_EventAddress') ?>

    <?= $form->field($model, 'vc_EventCity') ?>

    <?php // echo $form->field($model, 'dc_TransportCost') ?> 

    <?php // echo $form->field($model, 'dt_EventStart') ?>

    <?php // echo $form->field($model, 'dt_EventEnd') ?>

    <?php // echo $form->field($model, 'dc_EventCost') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
