<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UsrUsertype;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'inputOptions' => ['class' => 'form-control col-sm-10'],
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
            'template' => "{label}\n<div class=\"col-sm-10\">{input}</div>\n<div class=\"col-lg-8 col-lg-offset-2\">{error}</div>",
        ],
    ]); ?>          

    

    <?= $form->field($model, 'vc_FirstName')->textInput(['maxlength' => true]) ?>

    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'vc_LastName')->textInput(['maxlength' => true]) ?>

    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'vc_HashPassword')->passwordInput(['maxlength' => true]) ?>

    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'repeatpass')->passwordInput(['maxlength' => true,'inputOptions'=>['placeholder'=>'Repita la contraseña']]) ?>

    <div class="hr-line-dashed"></div>    

    <?= $form->field($model, 'vc_Email')->textInput(['maxlength' => true]) ?>

    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'vc_Phone')->textInput(['maxlength' => true]) ?>

    <div class="hr-line-dashed"></div>


    
    
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            
        
        <?= Html::a ( 'Cancelar', $url = Url::to('../site/login'), $options = ['class'=>'btn btn-white'] ) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear Cuenta') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-success']) ?>

        </div>


    </div>

    <?php ActiveForm::end(); ?>



</div>
<?php endif ?>

