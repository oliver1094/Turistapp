<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'i_Fk_UserType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_LastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_HashPassword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_CompanyName')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
