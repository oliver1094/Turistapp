<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EvtMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evt-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'i_FkTbl_Event')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_Latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_Longitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_EventTag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_TransportTag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_LatitudeTransport')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_LongitudeTransport')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
