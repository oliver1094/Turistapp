<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatuserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catuser-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'i_Pk_User') ?>

    <?= $form->field($model, 'i_Fk_UserType') ?>

    <?= $form->field($model, 'vc_FirstName') ?>

    <?= $form->field($model, 'vc_LastName') ?>

    <?= $form->field($model, 'vc_HashPassword') ?>

    <?php // echo $form->field($model, 'vc_Email') ?>

    <?php // echo $form->field($model, 'vc_Phone') ?>

    <?php // echo $form->field($model, 'vc_CompanyName') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
