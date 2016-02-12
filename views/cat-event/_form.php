<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-event-form">

    <?php $form = ActiveForm::begin(); ?>    

    <?= $form->field($model, 'vc_EventName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_EventAddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_EventCity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dt_EventStart')->textInput() ?>

    <?= $form->field($model, 'dt_EventEnd')->textInput() ?>

    <?= $form->field($model, 'dc_EventCost')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
