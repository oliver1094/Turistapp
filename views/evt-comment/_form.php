<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\EvtComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evt-comment-form">

     <?php $form = ActiveForm::begin([
      'action' => ['evt-comment/create'],
  ]); ?>

    <?= $form->field($model, 'i_FkTbl_Event')->hiddenInput(['value'=>$eventID])->label(false) ?>

    <?= $form->field($model, 'i_FkTbl_User')->hiddenInput(['value'=>$userID])->label(false)?>

    <?= $form->field($model, 'txt_EventComment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'i_Score')->widget(StarRating::classname(), ['pluginOptions' => ['size'=>'md',
                                                                                              'step' => '1.0',
                                                                                              'showClear'=> false,
                                                                                              'animate'=> false
                                                                                             ],
                                                                                              
                                                                         ])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
