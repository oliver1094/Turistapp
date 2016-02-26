<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SysCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'i_Pk_Score') ?>

    <?= $form->field($model, 'i_Fk_User') ?>

    <?= $form->field($model, 'i_Score') ?>

    <?= $form->field($model, 'vc_CommentSys') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
