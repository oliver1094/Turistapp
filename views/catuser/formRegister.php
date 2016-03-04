<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UsrUsertype;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="catuser-form">
          
        <?php if (Yii::$app->session->hasFlash('userFormSubmitted')): ?>

        <div class="alert alert-success">
            Se le ha enviado un correo para confirmar su correo y poder completar el registro.
        </div>

        <?php else: ?>

    <?php $form = ActiveForm::begin(); ?>            

    <?= $form->field($model, 'vc_FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_LastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_HashPassword')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repeatpass')->passwordInput(['maxlength' => true,'inputOptions'=>['placeholder'=>'Repita la contraseña']]) ?>    

    <?= $form->field($model, 'vc_Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_Phone')->textInput(['maxlength' => true]) ?>


    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>


    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php endif ?>

