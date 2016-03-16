<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\EvtMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-6">
<div class="evt-map-form">
    <?= Html::button(Yii::t('app', 'Mapa de evento'), ['class' => 'btn btn-primary', 'id'=>"buttonEvent"]) ?>
    <?= Html::button(Yii::t('app', 'Mapa de transporte'), ['class' => 'btn btn-primary', 'id'=>"buttonTrans"]) ?>

    <?php $form = ActiveForm::begin(); ?>
<div id="evtMapForm">
    <?= $form->field($model, 'searchbox')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'vc_EventTag')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'i_FkTbl_Event'); ?>

    <?= Html::activeHiddenInput($model, 'vc_Latitude'); ?>

    <?= Html::activeHiddenInput($model, 'vc_Longitude'); ?>

</div>
<div id="transMapForm">
    <?= $form->field($model, 'searchboxTransport')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'vc_TransportTag')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'vc_LatitudeTransport'); ?>

    <?= Html::activeHiddenInput($model, 'vc_LongitudeTransport'); ?>

</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>

</div>
</div>
<div id = "eventMapDiv" class="col-md-6">
    <p>
    <?= Html::button(Yii::t('app', 'Mi ubicación actual'), ['class' => 'btn btn-primary', 'id'=>"currentLocationE"]) ?>
    </p>
    <div id = "textE"><p>Buscando...<span id="statusE"></span></p></div>
    <div id="eventMap"  style="width:500px;height:380px;">
    </div>
</div>

<div id = "transportMapDiv" class="col-md-6">
    <p>
    <?= Html::button(Yii::t('app', 'Mi ubicación actual'), ['class' => 'btn btn-primary', 'id'=>"currentLocationT"]) ?>
    <?= Html::button(Yii::t('app', 'Eliminar marcador'), ['class' => 'btn btn-danger', 'id'=>"clearTransport"]) ?>
    </p>
    <div id = "textT"><p>Buscando...<span id="statusT"></span></p></div>
    <div id="transportMap" style="width:500px;height:380px;">
    </div>
</div>
