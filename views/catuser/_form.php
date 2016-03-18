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

<?php if($model->isNewRecord){
    $this->registerJs('
        $("[value=\'1\']").prop("checked", true);
    ');
} ?>

<?php $this->registerJs('

    

    function showCompanyName()
    {
        $("[name=\'Catuser[vc_CompanyName]\']").removeAttr("disabled");
        $(".field-catuser-vc_companyname").show();        
    }
    
    function hideCompanyName()
    {
        $("[name=\'Catuser[vc_CompanyName]\']").attr("disabled","disabled");
        $(".field-catuser-vc_companyname").hide();
    }

    function toggleStudentId()
    {
        var registrationType = $("[name=\'Catuser[i_Fk_UserType]\']:checked").val();
        switch(registrationType)
        {
            case "1": hideCompanyName(); break;
            case "2": showCompanyName(); break;
            case "3": hideCompanyName(); break;
            
        }
    }

    hideCompanyName();
     $("input[type=radio][name=\'Catuser[i_Fk_UserType]\']").change(function(){
            toggleStudentId();
     });
     

    


'); ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <b>Sucedió algo inesperado:</b> No se ha podido cambiar la información correctamente, intentelo más tarde.
    </div>
<?php endif ?>

<div class="catuser-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'inputOptions' => ['class' => 'form-control col-sm-10'],
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
            'template' => "{label}\n<div class=\"col-sm-10\">{input}</div>\n<div class=\"col-lg-8 col-lg-offset-2\">{error}</div>",
        ],
    ]); ?>

    

    <?= $form->field($model, 'i_Fk_UserType')->radioList(
        ArrayHelper::map(
            UsrUsertype::find()->all(),
            'i_Pk_UserType',
            'vc_NameUserType'
        )
    ) ?>

    <div class="hr-line-dashed"></div>
    
    <?= $form->field($model, 'vc_FirstName')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'vc_LastName')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

<?php if ($model->isNewRecord): ?>

    <?= $form->field($model, 'vc_HashPassword')->passwordInput(['maxlength' => true]) ?>    
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'repeatpass')->passwordInput(['maxlength' => true,'inputOptions'=>['placeholder'=>'Repita la contraseña']]) ?>
    <div class="hr-line-dashed"></div>

<?php endif ?>

    <?= $form->field($model, 'vc_Email')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'vc_Phone')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'vc_CompanyName')->textInput(['maxlength' => true]) ?>

    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            
        
        <?= Html::a ( 'Cancelar', $url = Url::to('index'), $options = ['class'=>'btn btn-white'] ) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Registrar Usuario') : Yii::t('app', 'Actualizar Usuario'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        </div>


    </div>


    <?php ActiveForm::end(); ?>

</div>
