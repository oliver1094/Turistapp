<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\SysComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-comment-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'i_Fk_User')->hiddenInput(['value'=> $userID])->label(false)?>

        <?= $form->field($model, 'i_Score')->widget(StarRating::classname(),
         ['pluginOptions' => 
          [
            'size'=>'md',
            'step' => '1.0',
            'showClear'=> false,
            'animate'=> false
          ],
        ])?>

        <?= $form->field($model, 'vc_CommentSys')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Enviar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
    

</div>
