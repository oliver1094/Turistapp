<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EvtCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evt-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'i_FkTbl_Event') ?>

    <?= $form->field($model, 'i_FkTbl_User') ?>

    <?= $form->field($model, 'txt_EventComment') ?>

    <?= $form->field($model, 'i_Score') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
