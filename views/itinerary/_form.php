<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Itinerary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="itinerary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'i_FkTbl_User')->textInput(['readonly' => true,'value'=>$userID]) ?>

    <?= $form->field($model, 'i_FkTbl_Event')->textInput(['maxlength' => true,'placeholder'=>'Enter the Event Id']) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
